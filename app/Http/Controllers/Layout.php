<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\trnjadi;
use App\Models\trnsales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Layout extends Controller
{
    //

    public function index()
    {
        $tanggalAwal = date('Y-m-01');
        $tanggalAkhir = date('Y-m-t');

        $idDepo = getIdDepo();
        if ($idDepo == 000) {
            $penjualanBarang = trnjadi::where('KDTRN', 12)
                ->whereBetween('TANGGAL', [$tanggalAwal, $tanggalAkhir]) // Tanggal harus berada di antara tanggal awal dan akhir
                ->join('barang', 'trnjadi.ID_BARANG', '=', 'barang.ID_BARANG')
                ->select(
                    'trnjadi.ID_BARANG',
                    'barang.NAMA',
                    DB::raw('SUM(trnjadi.HARGA) as total_penjualan'),
                    DB::raw('SUM(trnjadi.POTONGAN) as total_potongan'),
                    DB::raw('SUM(trnjadi.JUMLAH) as total_netto')
                ) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA')
                ->get();

            $penjualanSalesman = trnsales::where('KDTRN', 12)
                ->whereNotNull('trnsales.ID_SALESMAN')
                ->where('trnsales.ID_SALESMAN', '!=', '')
                ->whereBetween('trnsales.TANGGAL', [$tanggalAwal, $tanggalAkhir])
                ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
                ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA')
                ->get();

            $penjualanCustomer = trnsales::where('trnsales.KDTRN', 12)
                ->whereNotNull('trnsales.ID_CUSTOMER')
                ->where('trnsales.ID_CUSTOMER', '!=', '')
                ->whereBetween('trnsales.TANGGAL', [$tanggalAwal, $tanggalAkhir])
                ->join('customer', 'trnsales.ID_CUSTOMER', '=', 'customer.ID_CUSTOMER')
                ->select('trnsales.ID_CUSTOMER', 'customer.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA')
                ->get();

            $stok = DB::table('stkjadi')
                ->join('gudang', 'stkjadi.ID_GUDANG', 'gudang.ID_GUDANG')
                ->select('stkjadi.SALDO', 'gudang.NAMA', 'stkjadi.ID_GUDANG')
                ->groupBy('stkjadi.SALDO', 'gudang.NAMA', 'stkjadi.ID_GUDANG')
                ->get();
        } else {
            $penjualanBarang = trnjadi::where('KDTRN', 12)
                ->where('trnjadi.ID_DEPO', getIdDepo())
                ->whereBetween('TANGGAL', [$tanggalAwal, $tanggalAkhir]) // Tanggal harus berada di antara tanggal awal dan akhir
                ->join('barang', 'trnjadi.ID_BARANG', '=', 'barang.ID_BARANG')
                ->select(
                    'trnjadi.ID_BARANG',
                    'barang.NAMA',
                    DB::raw('SUM(trnjadi.HARGA) as total_penjualan'),
                    DB::raw('SUM(trnjadi.POTONGAN) as total_potongan'),
                    DB::raw('SUM(trnjadi.JUMLAH) as total_netto')
                ) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnjadi.ID_BARANG', 'barang.NAMA')
                ->get();

            $penjualanSalesman = trnsales::where('KDTRN', 12)
                ->where('trnsales.ID_DEPO', getIdDepo())
                ->whereNotNull('trnsales.ID_SALESMAN')
                ->where('trnsales.ID_SALESMAN', '!=', '')
                ->whereBetween('trnsales.TANGGAL', [$tanggalAwal, $tanggalAkhir])
                ->join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
                ->select('trnsales.ID_SALESMAN', 'salesman.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_SALESMAN', 'salesman.NAMA')
                ->get();

            $penjualanCustomer = trnsales::where('trnsales.KDTRN', 12)
                ->where('trnsales.ID_DEPO', getIdDepo())
                ->whereNotNull('trnsales.ID_CUSTOMER')
                ->where('trnsales.ID_CUSTOMER', '!=', '')
                ->whereBetween('trnsales.TANGGAL', [$tanggalAwal, $tanggalAkhir])
                ->join('customer', 'trnsales.ID_CUSTOMER', '=', 'customer.ID_CUSTOMER')
                ->select('trnsales.ID_CUSTOMER', 'customer.NAMA', DB::raw('SUM(trnsales.JUMLAH) as total_penjualan'), DB::raw('SUM(trnsales.DISCOUNT) as total_potongan'), DB::raw('SUM(trnsales.NETTO) as total_netto')) // Menggunakan fungsi SUM() untuk menjumlahkan penjualan
                ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA')
                ->get();

            $stok = DB::table('stkjadi')
                ->where('stkjadi.ID_DEPO', getIdDepo())
                ->join('gudang', 'stkjadi.ID_GUDANG', 'gudang.ID_GUDANG')
                ->select('stkjadi.SALDO', 'gudang.NAMA', 'stkjadi.ID_GUDANG')
                ->groupBy('stkjadi.SALDO', 'gudang.NAMA', 'stkjadi.ID_GUDANG')
                ->get();
        }

        return View('layout.dashboard', compact('penjualanBarang', 'penjualanSalesman', 'penjualanCustomer', 'stok', 'tanggalAwal', 'tanggalAkhir'));
    }
}
