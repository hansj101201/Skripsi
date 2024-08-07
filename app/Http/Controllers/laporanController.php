<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\gudang;
use App\Models\satuan;
use App\Models\trnjadi;
use App\Models\trnsales;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class laporanController extends Controller
{
    //
    public function penjualan()
    {
        return view('laporan.penjualan.index');
    }

    public function stok()
    {
        $periode = trnsales::select('PERIODE')
            ->orderBy('PERIODE', 'desc')
            ->distinct()
            ->get();

        if (getIdDepo() != 000) {
            $gudang = gudang::where('ACTIVE', 1)
                ->where('ID_DEPO', getIdDepo())
                ->select('gudang.ID_GUDANG', 'gudang.NAMA')
                ->get();
        } else {
            $gudang = gudang::where('ACTIVE', 1)
                ->select('gudang.ID_GUDANG', 'gudang.NAMA')
                ->get();
        }

        // return response()->json($gudang);
        return view('laporan.stok.index', compact('gudang', 'periode'));
    }

    public function getStok($periode, $idGudang)
    {
        $tahun = substr($periode, 0, 4);
        $bulan = (int) substr($periode, 4, 2);

        // Mendapatkan daftar barang yang ada di gudang
        $daftarBarang = DB::table('stkjadi')
            ->join('barang','barang.ID_BARANG','stkjadi.ID_BARANG')
            ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
            ->select('stkjadi.ID_BARANG','satuan.NAMA AS namasatuan','barang.NAMA AS namabarang')
            ->where('ID_GUDANG', $idGudang)
            ->groupBy('stkjadi.ID_BARANG','barang.NAMA','satuan.NAMA')
            ->get();
        // Array untuk menyimpan informasi stok per barang
        $stokPerBarang = array();
        foreach ($daftarBarang as $barang) {

            $stokAwal = $this->hitungStokAwalPerBarang($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $stokAkhir = $this->hitungStokAkhirPerBarang($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $totalTerima = $this->sumTerima($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $totalKeluar = $this->sumKeluar($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $totalAdjust = $this->sumAdjust($idGudang, $barang->ID_BARANG, $tahun, $bulan);

            // Menyimpan informasi stok per barang ke dalam array
            $newItem = [
                'ID_BARANG' => $barang->ID_BARANG,
                'NAMA_BARANG' => $barang->namabarang,
                'SATUAN' => $barang->namasatuan,
                'ADJUST' => $totalAdjust,
                'TOTAL_TERIMA' => $totalTerima,
                'TOTAL_KELUAR' => $totalKeluar,
                'STOK_AWAL' => $stokAwal['STOK_AWAL'],
                'STOK_AKHIR' => $stokAkhir['STOK_AKHIR'],
                'PERIODE' => $periode,
                'GUDANG' => $idGudang
            ];
            array_push($stokPerBarang, $newItem);
        }

        $stokPerBarangCollection = collect($stokPerBarang);

        // Map the collection to convert each item to an object
        $stokPerBarangObject = $stokPerBarangCollection->map(function ($item) {
            return (object) $item;
        });

        return DataTables::of($stokPerBarangObject)
            ->addColumn('action', function ($row) {
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal"
            data-target="#DataModal" data-kode="' . $row->ID_BARANG . '" data-satuan="' . $row->SATUAN . '" data-awal="' . $row->STOK_AWAL . '" data-akhir="' . $row->STOK_AKHIR . '"
            data-nama="' . $row->NAMA_BARANG . '" data-periode="' . $row->PERIODE . '" data-gudang="' . $row->GUDANG . '">
            <span class="fas fa-eye"></span></button> &nbsp';
                return $actionButtons;
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    private function hitungStokAwalPerBarang($idGudang, $idBarang, $tahun, $bulan)
    {
        $saldoAwal = DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum('SALDOAWAL');

        $totalTerima = 0;
        $totalKeluar = 0;
        $totalTerimaGdg = 0;
        $totalKeluarGdg = 0;
        $totalAdjust = 0;

        for ($i = 1; $i < $bulan; $i++) {
            $totalTerima += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("TERIMA" . sprintf("%02d", $i));

            $totalKeluar += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("KELUAR" . sprintf("%02d", $i));

            $totalTerimaGdg += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("TRMGDG" . sprintf("%02d", $i));

            $totalKeluarGdg += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("KLRGDG" . sprintf("%02d", $i));

            $totalAdjust += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("ADJUST" . sprintf("%02d", $i));
        }

        $stokAkhir = $saldoAwal + $totalTerima - $totalKeluar + $totalTerimaGdg - $totalKeluarGdg + $totalAdjust;

        return [
            'STOK_AWAL' => $stokAkhir
        ];
    }

    private function hitungStokAkhirPerBarang($idGudang, $idBarang, $tahun, $bulan)
    {
        $saldoAwal = DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum('SALDOAWAL');

        $totalTerima = 0;
        $totalKeluar = 0;
        $totalTerimaGdg = 0;
        $totalKeluarGdg = 0;
        $totalAdjust = 0;

        for ($i = 1; $i <= $bulan; $i++) {
            $totalTerima += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("TERIMA" . sprintf("%02d", $i));

            $totalKeluar += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("KELUAR" . sprintf("%02d", $i));

            $totalTerimaGdg += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("TRMGDG" . sprintf("%02d", $i));

            $totalKeluarGdg += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("KLRGDG" . sprintf("%02d", $i));

            $totalAdjust += DB::table('stkjadi')
                ->where('ID_GUDANG', $idGudang)
                ->where('ID_BARANG', $idBarang)
                ->where('TAHUN', $tahun)
                ->sum("ADJUST" . sprintf("%02d", $i));
        }

        $stokAkhir = $saldoAwal + $totalTerima - $totalKeluar + $totalTerimaGdg - $totalKeluarGdg + $totalAdjust;

        return [
            'STOK_AKHIR' => $stokAkhir
        ];
    }

    private function sumTerima($idGudang, $idBarang, $tahun, $bulan)
    {
        $totalTerima = 0;
        $totalTerimaGdg = 0;

        // Sum terima untuk bulan tersebut
        $totalTerima += DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum("TERIMA" . sprintf("%02d", $bulan));

        // Sum terima gudang untuk bulan tersebut
        $totalTerimaGdg += DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum("TRMGDG" . sprintf("%02d", $bulan));

        return $totalTerima + $totalTerimaGdg;
    }

    private function sumKeluar($idGudang, $idBarang, $tahun, $bulan)
    {
        $totalKeluar = 0;
        $totalKeluarGdg = 0;

        // Sum Keluar untuk bulan tersebut
        $totalKeluar += DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum("KELUAR" . sprintf("%02d", $bulan));

        // Sum Keluar gudang untuk bulan tersebut
        $totalKeluarGdg += DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum("KLRGDG" . sprintf("%02d", $bulan));

        return $totalKeluar + $totalKeluarGdg;
    }

    private function sumAdjust($idGudang, $idBarang, $tahun, $bulan)
    {
        $totalAdjust = 0;

        // Sum Adjust untuk bulan tersebut
        $totalAdjust += DB::table('stkjadi')
            ->where('ID_GUDANG', $idGudang)
            ->where('ID_BARANG', $idBarang)
            ->where('TAHUN', $tahun)
            ->sum("ADJUST" . sprintf("%02d", $bulan));

        return $totalAdjust;
    }

    public function getDetailTrn($periode, $idGudang, $idBarang)
    {
        $trnjadis = trnjadi::where('ID_BARANG', $idBarang)
            ->where('ID_GUDANG', $idGudang)
            ->where('PERIODE', $periode)
            ->where('trnjadi.KDTRN','!=','30')
            ->select('trnjadi.KDTRN', 'trnjadi.TANGGAL', 'trnjadi.BUKTI', 'trnjadi.KET01', 'trnjadi.QTY')
            ->orderBy('TANGGAL')
            ->orderBy('BUKTI')
            ->get();

        $data = [];

        foreach ($trnjadis as $trnjadi) {
            $masuk = null;
            $keluar = null;

            if ($trnjadi->KDTRN == '01' || $trnjadi->KDTRN == '05') {
                $masuk = $trnjadi->QTY;
                $keluar = 0;
            } else if ($trnjadi->KDTRN == '12' || $trnjadi->KDTRN == '15') {
                $keluar = $trnjadi->QTY;
                $masuk = 0;
            } else if ($trnjadi->KDTRN == '09') {
                if ($trnjadi->QTY < 0) {
                    $keluar = $trnjadi->QTY * -1;
                    $masuk = 0;
                } else if ($trnjadi->QTY > 0) {
                    $masuk = $trnjadi->QTY;
                    $keluar = 0;
                }
            }

            $item = [
                'TANGGAL' => $trnjadi->TANGGAL,
                'BUKTI' => $trnjadi->BUKTI,
                'KETERANGAN' => $trnjadi->KET01,
                'MASUK' => $masuk,
                'KELUAR' => $keluar,
            ];

            array_push($data, $item);
        }
        $dataCollection = collect($data);

        // Map the collection to convert each item to an object
        $dataObject = $dataCollection->map(function ($item) {
            return (object) $item;
        });

        // dump($dataObject);
        return DataTables::of($dataObject)
            ->make(true);
    }

    public function getPenjualanCustomer($awal, $akhir)
    {
        $idDepo = getIdDepo();
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        if ($idDepo == 000) {
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
                ->whereNotNull('trnsales.ID_CUSTOMER')
                ->where('trnsales.ID_CUSTOMER', '!=', '')
                ->join('customer', 'trnsales.ID_CUSTOMER', '=', 'customer.ID_CUSTOMER')
                ->select('trnsales.ID_CUSTOMER', 'customer.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA');
        } else {
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
                ->where('trnsales.ID_DEPO', $idDepo)
                ->whereNotNull('trnsales.ID_CUSTOMER')
                ->where('trnsales.ID_CUSTOMER', '!=', '')
                ->join('customer', 'trnsales.ID_CUSTOMER', '=', 'customer.ID_CUSTOMER')
                ->select('trnsales.ID_CUSTOMER', 'customer.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA');
        }

        if ($TanggalAwal == $TanggalAkhir) {
            $trnsales->whereDate('TANGGAL', $TanggalAwal);
        } else {
            $trnsales->whereBetween('TANGGAL', [$TanggalAwal, $TanggalAkhir]);
        }

        return Datatables::of($trnsales)
            ->addColumn('action', function ($row) {
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#DataModal" data-mode="Customer" data-kode="' . $row->ID_CUSTOMER . '" data-nama="' . $row->NAMA . '"><span class="fas fa-eye"></span></button> &nbsp';
                return $actionButtons;
            })
            ->rawColumns(["action"])
            ->make(true);
    }


    public function getPenjualanSalesman($awal, $akhir)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        $idDepo = getIdDepo();
        if ($idDepo == 000) {
            $trnsales = trnsales::where('KDTRN', 12)
                ->whereNotNull('trnsales.ID_SALESMAN')
                ->where('trnsales.ID_SALESMAN', '!=', '')
                ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
                ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA');
        } else {
            $trnsales = trnsales::where('KDTRN', 12)
                ->where('trnsales.ID_DEPO', $idDepo)
                ->whereNotNull('trnsales.ID_SALESMAN')
                ->where('trnsales.ID_SALESMAN', '!=', '')
                ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
                ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA');
        }

        if ($TanggalAwal == $TanggalAkhir) {
            $trnsales->whereDate('TANGGAL', $TanggalAwal);
        } else {
            $trnsales->whereBetween('TANGGAL', [$TanggalAwal, $TanggalAkhir]);
        }
        return Datatables::of($trnsales)
            ->addColumn('action', function ($row) {
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#DataModal" data-mode="Salesman" data-kode="' . $row->ID_SALESMAN . '" data-nama="' . $row->NAMA . '"><span class="fas fa-eye"></span></button> &nbsp';
                return $actionButtons;
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function getPenjualanBarang($awal, $akhir)
    {
        // Mengubah format tanggal input ke format Y-m-d
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal)->format('Y-m-d');
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir)->format('Y-m-d');
        $idDepo = getIdDepo();

        if ($idDepo == 000) {
            $trnjadi = trnjadi::where('KDTRN', 12)
                ->join('barang', 'trnjadi.ID_BARANG', '=', 'barang.ID_BARANG')
                ->select(
                    'trnjadi.ID_BARANG',
                    'barang.NAMA',
                    DB::raw('SUM(trnjadi.Qty) as total_qty'),
                    DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as total_penjualan'), // Perkalian QTY dengan HARGA dan menjumlahkannya
                    DB::raw('SUM(trnjadi.POTONGAN) as total_potongan'),
                    DB::raw('SUM(trnjadi.JUMLAH) as total_netto') // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                )
                ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA');
        } else {
            $trnjadi = trnjadi::where('KDTRN', 12)
                ->where('trnjadi.ID_DEPO', $idDepo)
                ->join('barang', 'trnjadi.ID_BARANG', '=', 'barang.ID_BARANG')
                ->select(
                    'trnjadi.ID_BARANG',
                    'barang.NAMA',
                    DB::raw('SUM(trnjadi.Qty) as total_qty'),
                    DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as total_penjualan'), // Perkalian QTY dengan HARGA dan menjumlahkannya
                    DB::raw('SUM(trnjadi.POTONGAN) as total_potongan'),
                    DB::raw('SUM(trnjadi.JUMLAH) as total_netto') // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                )
                ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA');
        }

        if ($TanggalAwal == $TanggalAkhir) {
            $trnjadi->whereDate('TANGGAL', $TanggalAwal);
        } else {
            $trnjadi->whereBetween('TANGGAL', [$TanggalAwal, $TanggalAkhir]);
        }

        return Datatables::of($trnjadi)->make(true);
    }


    public function getDetailPenjualanCustomer($idCustomer, $awal, $akhir)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->where('trnsales.ID_CUSTOMER', $idCustomer)
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN');
            })
            ->join('barang', 'trnjadi.ID_BARANG', 'barang.ID_BARANG')
            ->join('satuan', 'barang.ID_SATUAN', 'satuan.ID_SATUAN')
            ->select(
                'trnjadi.ID_BARANG',
                'barang.NAMA AS nama_barang',
                'satuan.NAMA AS nama_satuan',
                'trnjadi.TANGGAL',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah')
            )
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA','trnjadi.TANGGAL', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG');

            if ($TanggalAwal == $TanggalAkhir) {
                $trnsales->whereDate('trnjadi.TANGGAL', $TanggalAwal);
            } else {
                $trnsales->whereBetween('trnjadi.TANGGAL', [$TanggalAwal, $TanggalAkhir]);
            }
        return Datatables::of($trnsales)
            ->make(true);
    }

    public function getDetailPenjualanSalesman($idSales, $awal, $akhir)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->where('trnsales.ID_SALESMAN', $idSales)
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN');
            })
            ->join('barang', 'trnjadi.ID_BARANG', 'barang.ID_BARANG')
            ->join('satuan', 'barang.ID_SATUAN', 'satuan.ID_SATUAN')
            ->select(
                'trnjadi.ID_BARANG',
                'barang.NAMA AS nama_barang',
                'satuan.NAMA AS nama_satuan',
                'trnjadi.TANGGAL',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah')
            )
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA','trnjadi.TANGGAL', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG');
            if ($TanggalAwal == $TanggalAkhir) {
                $trnsales->whereDate('trnjadi.TANGGAL', $TanggalAwal);
            } else {
                $trnsales->whereBetween('trnjadi.TANGGAL', [$TanggalAwal, $TanggalAkhir]);
            }
        return Datatables::of($trnsales)
            ->make(true);
    }
}
