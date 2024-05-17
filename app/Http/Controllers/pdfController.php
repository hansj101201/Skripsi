<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\pdfEmail;
use App\Models\barang;
use App\Models\depo;
use App\Models\satuan;
use App\Models\trnjadi;
use App\Models\trnsales;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class pdfController extends Controller
{
    //

    public function index(){
        $depo = depo::all();
        return view('pdf.penjualan.index', compact('depo'));
    }
    public function getStok($periode, $idGudang)
    {
        $tahun = substr($periode, 0, 4);
        $bulan = (int) substr($periode, 4, 2);

        // Mendapatkan daftar barang yang ada di gudang
        $daftarBarang = DB::table('stkjadi')
            ->select('ID_BARANG')
            ->where('ID_GUDANG', $idGudang)
            ->groupBy('ID_BARANG')
            ->get();
        // Array untuk menyimpan informasi stok per barang
        $stokPerBarang = array();

        foreach ($daftarBarang as $barang) {

            $stokAwal = $this->hitungStokAwalPerBarang($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $stokAkhir = $this->hitungStokAkhirPerBarang($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $totalTerima = $this->sumTerima($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $totalKeluar = $this->sumKeluar($idGudang, $barang->ID_BARANG, $tahun, $bulan);
            $totalAdjust = $this->sumAdjust($idGudang, $barang->ID_BARANG, $tahun, $bulan);

            // Mendapatkan informasi barang dan satuan
            $barangInfo = barang::where('ID_BARANG',$barang->ID_BARANG)->first();
            $satuanInfo = satuan::where('ID_SATUAN',$barangInfo->ID_SATUAN)->first();

            // Menyimpan informasi stok per barang ke dalam array
            $newItem = [
                'ID_BARANG' => $barangInfo->ID_BARANG,
                'NAMA_BARANG' => $barangInfo->NAMA,
                'SATUAN' => $satuanInfo->NAMA,
                'ADJUST' => $totalAdjust,
                'TOTAL_TERIMA' => $totalTerima,
                'TOTAL_KELUAR' => $totalKeluar,
                'STOK_AWAL' => $stokAwal['STOK_AWAL'],
                'STOK_AKHIR' => $stokAkhir['STOK_AKHIR'],
                'PERIODE' => $periode,
                'GUDANG' => $idGudang,
                'DETAIL_TRN' => $this->getDetailTrn($periode, $idGudang, $barangInfo->ID_BARANG)
            ];

            array_push($stokPerBarang, $newItem);
        }

        $stokPerBarangCollection = collect($stokPerBarang);

    // Map the collection to convert each item to an object
        $stokPerBarangObject = $stokPerBarangCollection->map(function ($item) {
            return (object) $item;
        });

        // return $stokPerBarangObject;
        return response()->json($stokPerBarangObject);
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
            }  else if ($trnjadi->KDTRN == '09'){
                if($trnjadi->QTY < 0){
                    $keluar = $trnjadi->QTY * -1;
                    $masuk = 0;
                } else if ($trnjadi->QTY > 0){
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

            array_push($data,$item);
        }
        $dataCollection = collect($data);

    // Map the collection to convert each item to an object
        $dataObject = $dataCollection->map(function ($item) {
            return (object) $item;
        });
        return $dataObject;
    }

    public function getAllPenjualanCustomer($awal, $akhir)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->whereNotNull('trnsales.ID_CUSTOMER')
            ->where('trnsales.ID_CUSTOMER', '!=', '')
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->join('depo','trnsales.ID_DEPO','depo.ID_DEPO')
            ->select('depo.NAMA','trnsales.ID_DEPO', DB::raw('SUM(trnsales.JUMLAH) as TOTAL_PENJUALAN'), DB::raw('SUM(trnsales.DISCOUNT) as TOTAL_POTONGAN'), DB::raw('SUM(trnsales.NETTO) as TOTAL_NETTO'))
            ->groupBy('trnsales.ID_DEPO', 'depo.NAMA')
            ->get();


        $penjualanCustomer = [];

        foreach ($trnsales as $penjualan) {
            $penjualanDetail = $this->getPenjualanCustomer($awal, $akhir, $penjualan->ID_DEPO);

            $penjualanCustomer[] = [
                'ID_DEPO' => $penjualan->ID_DEPO,
                'NAMADEPO' => $penjualan->NAMA,
                'TOTAL_PENJUALAN_ALL' => $penjualan->TOTAL_PENJUALAN,
                'TOTAL_POTONGAN_ALL' => $penjualan->TOTAL_POTONGAN,
                'TOTAL_NETTO_ALL' => $penjualan->TOTAL_NETTO,
                'PENJUALAN' => $penjualanDetail
            ];
        }
        return $penjualanCustomer;
    }

    public function getAllPenjualanSalesman($awal, $akhir)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        $trnsales = trnsales::where('KDTRN',12)
            ->whereNotNull('trnsales.ID_SALESMAN') // Menentukan tabel sumber
            ->where('trnsales.ID_SALESMAN', '!=', '') // Menentukan tabel sumber
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir]) // Menentukan tabel sumber
            ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES') // Menentukan tabel sumber
            ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
            ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA') // Menentukan tabel sumber
            ->get();

        $penjualanSalesman = [];

        foreach ($trnsales as $penjualan) {
            $penjualanDetail = $this->getPenjualanSalesman($awal, $akhir, $penjualan->ID_DEPO);

            $penjualanSalesman[] = [
                'ID_DEPO' => $penjualan->ID_DEPO,
                'NAMADEPO' => $penjualan->NAMA,
                'TOTAL_PENJUALAN_ALL' => $penjualan->TOTAL_PENJUALAN,
                'TOTAL_POTONGAN_ALL' => $penjualan->TOTAL_POTONGAN,
                'TOTAL_NETTO_ALL' => $penjualan->TOTAL_NETTO,
                'PENJUALAN' => $penjualanDetail
            ];
        }
        return $penjualanSalesman;
    }

    public function getPenjualanCustomer($awal, $akhir, $depo)
    {

        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        if($depo == 000){
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->whereNotNull('trnsales.ID_CUSTOMER')
            ->where('trnsales.ID_CUSTOMER', '!=', '')
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->join('customer', 'trnsales.ID_CUSTOMER', '=', 'customer.ID_CUSTOMER')
            ->join('depo','trnsales.ID_DEPO','depo.ID_DEPO')
            ->select('depo.NAMA as namaDepo','trnsales.ID_DEPO','trnsales.ID_CUSTOMER', 'customer.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto'))
            ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA')
            ->get();
        } else {
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->where('trnsales.ID_DEPO', $depo)
            ->whereNotNull('trnsales.ID_CUSTOMER')
            ->where('trnsales.ID_CUSTOMER', '!=', '')
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->join('customer', 'trnsales.ID_CUSTOMER', '=', 'customer.ID_CUSTOMER')
            ->select('trnsales.ID_CUSTOMER', 'customer.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto'))
            ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA')
            ->get();
        }

        $penjualanCustomer = [];

        foreach ($trnsales as $penjualan) {
            $detailPenjualan = $this->getDetailPenjualanCustomer($penjualan->ID_CUSTOMER, $awal, $akhir, $depo);

            $penjualanCustomer[] = [
                'ID_CUSTOMER' => $penjualan->ID_CUSTOMER,
                'NAMA' => $penjualan->NAMA,
                'TOTAL_PENJUALAN' => $penjualan->total_penjualan,
                'TOTAL_POTONGAN' => $penjualan->total_potongan,
                'TOTAL_NETTO' => $penjualan->total_netto,
                'DETAIL_PENJUALAN' => $detailPenjualan
            ];
        }
        return $penjualanCustomer;
    }


    public function getPenjualanSalesman($awal, $akhir, $depo)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        if($depo == 000){
            $trnsales = trnsales::where('KDTRN',12)
            ->whereNotNull('trnsales.ID_SALESMAN') // Menentukan tabel sumber
            ->where('trnsales.ID_SALESMAN', '!=', '') // Menentukan tabel sumber
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir]) // Menentukan tabel sumber
            ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES') // Menentukan tabel sumber
            ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
            ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA') // Menentukan tabel sumber
            ->get();
        } else {
            $trnsales = trnsales::where('KDTRN',12)
            ->where('trnsales.ID_DEPO', $depo)
            ->whereNotNull('trnsales.ID_SALESMAN') // Menentukan tabel sumber
            ->where('trnsales.ID_SALESMAN', '!=', '') // Menentukan tabel sumber
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir]) // Menentukan tabel sumber
            ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES') // Menentukan tabel sumber
            ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
            ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA') // Menentukan tabel sumber
            ->get();

        }

        $penjualanBarang = [];

        foreach ($trnsales as $penjualan) {
            $detailPenjualan = $this->getDetailPenjualanSalesman($penjualan->ID_SALESMAN, $awal, $akhir, $depo);

            $penjualanBarang[] = [
                'ID_SALESMAN' => $penjualan->ID_SALESMAN,
                'NAMA' => $penjualan->NAMA,
                'TOTAL_PENJUALAN' => $penjualan->total_penjualan,
                'TOTAL_POTONGAN' => $penjualan->total_potongan,
                'TOTAL_NETTO' => $penjualan->total_netto,
                'DETAIL_PENJUALAN' => $detailPenjualan
            ];
        }

        // return response()->json($penjualanBarang);
        return $penjualanBarang;
    }

    public function getPenjualanBarang($awal, $akhir)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        $trnjadi = trnjadi::where('KDTRN',12)
            ->whereBetween('TANGGAL', [$TanggalAwal, $TanggalAkhir]) // Tanggal harus berada di antara tanggal awal dan akhir
            ->join('barang', 'trnjadi.ID_BARANG', '=', 'barang.ID_BARANG') // Menentukan tabel sumber
            ->select('trnjadi.ID_BARANG', 'barang.NAMA', DB::raw('SUM(trnjadi.HARGA) as total_penjualan'),
            DB::raw('SUM(trnjadi.POTONGAN) as total_potongan'), DB::raw('SUM(trnjadi.JUMLAH) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA') // Menentukan tabel sumber
            ->get();
    }

    public function getDetailPenjualanCustomer($idCustomer, $awal, $akhir, $depo)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        if($depo == 000){
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->where('trnsales.ID_CUSTOMER',$idCustomer)
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                    ->on('trnsales.ID_DEPO','=','trnjadi.ID_DEPO');
            })
            ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
            ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
            ->select('trnjadi.ID_BARANG', 'barang.NAMA AS nama_barang', 'satuan.NAMA AS nama_satuan',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah'))
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG')
            ->get();

        return $trnsales;
        } else {
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->where('trnsales.ID_DEPO', $depo)
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->where('trnsales.ID_CUSTOMER',$idCustomer)
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                    ->on('trnsales.ID_DEPO','=','trnjadi.ID_DEPO');
            })
            ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
            ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
            ->select('trnjadi.ID_BARANG', 'barang.NAMA AS nama_barang', 'satuan.NAMA AS nama_satuan',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah'))
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG')
            ->get();

        return $trnsales;
        }
    }

    public function getDetailPenjualanSalesman($idSales, $awal, $akhir, $depo)
    {
        $TanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
        $TanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
        if ($depo == 000){
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->where('trnsales.ID_SALESMAN',$idSales)
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN');
            })
            ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
            ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
            ->select('trnjadi.ID_BARANG', 'barang.NAMA AS nama_barang', 'satuan.NAMA AS nama_satuan',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah'))
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG')
            ->get();
        return $trnsales;
        } else {
            $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->where('trnsales.ID_DEPO', $depo)
            ->whereBetween('trnsales.TANGGAL', [$TanggalAwal, $TanggalAkhir])
            ->where('trnsales.ID_SALESMAN',$idSales)
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN');
            })
            ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
            ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
            ->select('trnjadi.ID_BARANG', 'barang.NAMA AS nama_barang', 'satuan.NAMA AS nama_satuan',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah'))
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG')
            ->get();
        return $trnsales;
        }

    }

    public function pdfCustomer($awal,$akhir,$depo)
    {
        if($depo == 000){
            $nama = 'Semua';
            $data = $this->getAllPenjualanCustomer($awal,$akhir);
            $view = 'pdf.penjualan.pdfCustSalesAll';
        } else {
            $nama = depo::where('ID_DEPO',$depo)
            ->value('NAMA');
            $data = $this->getPenjualanCustomer($awal,$akhir,$depo);
            $view = 'pdf.penjualan.pdfCustSales';
        }
        $data = [
            "printed_at" => Carbon::now()->isoFormat('D MMMM Y'),
            "data" => $data,
            "mode" => 'Customer',
            "awal" => $awal,
            "akhir" => $akhir,
            "nama" => $nama
        ];
        $pdf = SnappyPdf::loadView($view, $data)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('margin-top', 30)
            ->setOption('margin-bottom', 20)
            ->setOption("footer-right", "Halaman [page] dari [topage]")
            ->setOption("header-spacing", 5)
            ->setOption("footer-spacing", 5)
            ->setOption("enable-local-file-access", true)
            ->setOption('header-html', view('pdf.penjualan.header', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]))
            ->setOption('footer-html', view('pdf.penjualan.footer', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]))
            ->setOption('footer-font-size', 8);

        return $pdf->inline('Penjualan per Customer '.$awal.' - '.$akhir.'.pdf');
    }

    public function pdfSalesman($awal,$akhir, $depo)
    {
        if($depo == 000){
            $nama = 'Semua';
            $data = $this->getAllPenjualanSalesman($awal,$akhir);
            $view = 'pdf.penjualan.pdfCustSalesAll';
        } else {
            $nama = depo::where('ID_DEPO',$depo)
            ->value('NAMA');
            $data = $this->getPenjualanSales($awal,$akhir,$depo);
            $view = 'pdf.penjualan.pdfCustSales';
        }

        $data = [
            "printed_at" => Carbon::now()->isoFormat('D MMMM Y'),
            "data" => $data,
            "mode" => 'Salesman',
            "awal" => $awal,
            "akhir" => $akhir,
            "nama" => $depo
        ];
        $pdf = SnappyPdf::loadView($view, $data)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('margin-top', 30)
            ->setOption('margin-bottom', 20)
            ->setOption("footer-right", "Halaman [page] dari [topage]")
            ->setOption("header-spacing", 5)
            ->setOption("footer-spacing", 5)
            ->setOption("enable-local-file-access", true)
            ->setOption('header-html', view('pdf.penjualan.header', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]))
            ->setOption('footer-html', view('pdf.penjualan.footer', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]))
            ->setOption('footer-font-size', 8);

        return $pdf->inline('Penjualan per Salesman '.$awal.' - '.$akhir.'.pdf');
    }


    public function getPenjualanPerSalesman($bukti,$tahun){
        $trnsales = trnsales::where('KDTRN',12)
            ->where('trnsales.BUKTI', $bukti) // Menentukan tabel sumber
            ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES') // Menentukan tabel sumber
            ->join('customer', 'trnsales.ID_CUSTOMER', 'customer.ID_CUSTOMER')
            ->select('trnsales.ID_SALESMAN', 'salesman.NAMA',
                    DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'),
                    DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'),
                    DB::raw('SUM(trnsales.NETTO) as total_netto'),
                    'trnsales.ID_CUSTOMER', 'customer.NAMA as namacust',
                    'trnsales.TANGGAL', 'trnsales.BUKTI') // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
            ->whereRaw("LEFT(trnsales.PERIODE, 4) = '$tahun'")
            ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA', 'trnsales.ID_CUSTOMER', 'customer.NAMA', 'trnsales.TANGGAL', 'trnsales.BUKTI') // Menentukan tabel sumber
            ->get();

        $penjualanBarang = [];

        foreach ($trnsales as $penjualan) {
            $detailPenjualan = $this->getDetailPenjualanPerSalesman($bukti,$tahun);

            $penjualanBarang[] = [
                'ID_SALESMAN' => $penjualan->ID_SALESMAN,
                'NAMA' => $penjualan->NAMA,
                'ID_CUSTOMER' => $penjualan->ID_CUSTOMER,
                'NAMACUST' => $penjualan->namacust,
                'BUKTI' => $penjualan->BUKTI,
                'TANGGAL' => $penjualan->TANGGAL,
                'TOTAL_PENJUALAN' => $penjualan->total_penjualan,
                'TOTAL_POTONGAN' => $penjualan->total_potongan,
                'TOTAL_NETTO' => $penjualan->total_netto,
                'DETAIL_PENJUALAN' => $detailPenjualan
            ];
        }
        return $penjualanBarang;
    }

    public function getDetailPenjualanPerSalesman($bukti,$tahun)
    {
        $trnsales = trnsales::where('trnsales.KDTRN', 12)
            ->where('trnsales.BUKTI',$bukti)
            ->whereRaw("LEFT(trnsales.PERIODE, 4) = '$tahun'")
            ->join('trnjadi', function ($join) {
                $join->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                    ->on('trnsales.PERIODE', '=', 'trnjadi.PERIODE')
                    ->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN');
            })
            ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
            ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
            ->select('trnjadi.ID_BARANG', 'barang.NAMA AS nama_barang', 'satuan.NAMA AS nama_satuan',
                DB::raw('SUM(trnjadi.QTY) as total'),
                DB::raw('SUM(trnjadi.QTY * trnjadi.HARGA) as subtotal'),
                DB::raw('SUM(trnjadi.POTONGAN) as potongan'),
                DB::raw('SUM(trnjadi.JUMLAH) as jumlah'))
            ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA', 'satuan.NAMA')
            ->orderBy('trnjadi.ID_BARANG')
            ->get();
        return $trnsales;
    }

    public function generatePdf(Request $request)
    {
        $bukti = $request->BUKTI;
        $tahun = $request->TAHUN;

        $data = [
            "printed_at" => Carbon::now()->isoFormat('D MMMM Y'),
            "salesman" => $this->getPenjualanPerSalesman($bukti,$tahun)
        ];
        $pdf = SnappyPdf::loadView('pdf.penjualan.pdfInvoiceKanvas', $data)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('margin-top', 30)
            ->setOption('margin-bottom', 20)
            ->setOption("footer-right", "Halaman [page] dari [topage]")
            ->setOption("header-spacing", 5)
            ->setOption("footer-spacing", 5)
            ->setOption("enable-local-file-access", true)
            ->setOption('header-html', view('pdf.penjualan.header', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]))
            ->setOption('footer-html', view('pdf.penjualan.footer', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]));

        return $pdf->download($bukti.'.pdf');
    }

    public function sendEmail(Request $request)
    {

        $bukti = $request->BUKTI;
        $tahun = $request->TAHUN;
        $emailCustomer = trnsales::where('KDTRN',12)
            ->where('trnsales.BUKTI', $bukti)
            ->whereRaw("LEFT(trnsales.PERIODE, 4) = '$tahun'")
            ->join('customer', 'trnsales.ID_CUSTOMER', 'customer.ID_CUSTOMER')
            ->select('customer.EMAIL')
            ->first();

        $emailSalesman = trnsales::where('KDTRN',12)
            ->where('trnsales.BUKTI', $bukti)
            ->whereRaw("LEFT(trnsales.PERIODE, 4) = '$tahun'")
            ->join('salesman', 'trnsales.ID_SALESMAN', 'salesman.ID_SALES')
            ->select('salesman.EMAIL')
            ->first();
        $data = [
            "printed_at" => Carbon::now()->isoFormat('D MMMM Y'),
            "salesman" => $this->getPenjualanPerSalesman($bukti,$tahun)
        ];
        $pdf = SnappyPdf::loadView('pdf.penjualan.pdfInvoiceKanvas', $data)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('margin-top', 30)
            ->setOption('margin-bottom', 20)
            ->setOption("footer-right", "Halaman [page] dari [topage]")
            ->setOption("header-spacing", 5)
            ->setOption("footer-spacing", 5)
            ->setOption("enable-local-file-access", true)
            ->setOption('header-html', view('pdf.penjualan.header', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]))
            ->setOption('footer-html', view('pdf.penjualan.footer', ["printed_at" => Carbon::now()->isoFormat('D MMMM Y HH:mm:ss')]));

        // Generate a temporary file path to store the PDF
        $filePath = storage_path('app/example.pdf');
        $pdf->save($filePath);

        // Send email with PDF attachment
        Mail::to($emailCustomer)
        ->cc($emailSalesman)
        ->send(new pdfEmail($filePath));

        // Mail::to($emailCustomer)
        // ->cc($emailSalesman)
        // ->queue(new pdfEmail($filePath));

        // return response()->json(['message'=>'success'],200);

        return response()->json(['emailcustomer'=>$emailCustomer, 'emailsalesman'=>$emailSalesman]);
    }

}
