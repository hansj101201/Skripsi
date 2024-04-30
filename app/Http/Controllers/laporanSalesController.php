<?php

namespace App\Http\Controllers;

use App\Models\trnsales;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class laporanSalesController extends Controller
{
    //

    public function getPermintaan(Request $request){
        $idSales = $request->ID_SALES;
        $tanggal = $request->TANGGAL;
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
        $permintaan = trnsales::where('trnsales.KDTRN', 30)
        ->whereDate('trnsales.TANGGAL',$Tanggal)
        ->where('trnsales.ID_SALESMAN', $idSales)
        ->join('trnjadi', function ($join) {
            $join->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                ->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI');
        })
        ->join('barang','trnjadi.ID_BARANG', 'barang.ID_BARANG')
        ->select('trnsales.*', 'trnjadi.*', 'barang.NAMASINGKAT') // Select semua kolom
        ->orderBy('trnsales.BUKTI','asc')
        ->get();

        return response()->json($permintaan);
    }

    public function getPenerimaan (Request $request){
        $idSales = $request->ID_SALES;
        $tanggal = $request->TANGGAL;
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
        $permintaan = trnsales::where('trnsales.KDTRN', 15)
        ->whereDate('trnsales.TANGGAL',$Tanggal)
        ->whereRaw("LEFT(trnsales.NOPERMINTAAN, 3) = '$idSales'")
        ->join('trnjadi', function ($join) {
            $join->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                ->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI');
        })
        ->join('barang','trnjadi.ID_BARANG', 'barang.ID_BARANG')
        ->join('gudang','trnjadi.ID_GUDANG','gudang.ID_GUDANG')
        ->select('trnsales.*', 'trnjadi.*', 'barang.NAMASINGKAT', 'gudang.NAMA') // Select semua kolom
        ->orderBy('trnsales.BUKTI','asc')
        ->get();

        return response()->json($permintaan);
    }

    public function getPengembalian (Request $request){
        $idSales = $request->ID_SALES;
        $tanggal = $request->TANGGAL;
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
        $permintaan = trnsales::where('trnsales.KDTRN', 15)
        ->whereDate('trnsales.TANGGAL',$Tanggal)
        ->whereRaw("LEFT(trnsales.BUKTI, 3) = '$idSales'")
        ->join('trnjadi', function ($join) {
            $join->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                ->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI');
        })
        ->join('barang','trnjadi.ID_BARANG', 'barang.ID_BARANG')
        ->join('gudang','trnjadi.ID_GUDANG','gudang.ID_GUDANG')
        ->select('trnsales.*', 'trnjadi.*', 'barang.NAMASINGKAT', 'gudang.NAMA') // Select semua kolom
        ->orderBy('trnsales.BUKTI','asc')
        ->get();

        return response()->json($permintaan);
    }

    public function getPenjualan (Request $request)
    {
        $idSales = $request->ID_SALES;
        $tanggalAwal = DateTime::createFromFormat('d-m-Y', $request->TANGGALAWAL);
        $tanggalAkhir = DateTime::createFromFormat('d-m-Y', $request->TANGGALAKHIR);
        $penjualan = trnsales::where('trnsales.KDTRN', 12)
        ->where('trnsales.ID_SALESMAN', $idSales)
        ->whereBetween('trnsales.TANGGAL', [$tanggalAwal->format('Y-m-d'), $tanggalAkhir->format('Y-m-d')])
        ->join('trnjadi', function ($join) {
            $join->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                ->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                ->on('trnsales.PERIODE','=','trnjadi.PERIODE');
        })
        ->join('barang', 'trnjadi.ID_BARANG', 'barang.ID_BARANG')
        ->join('customer', 'trnsales.ID_CUSTOMER', 'customer.ID_CUSTOMER')
        ->select('trnsales.TANGGAL',
        'trnsales.DISCOUNT',
        'trnsales.BUKTI',
        'trnsales.ID_CUSTOMER',
        'trnsales.JUMLAH',
        'trnsales.NETTO',
        'trnjadi.QTY',
        'trnjadi.ID_BARANG',
        'barang.NAMASINGKAT',
        'customer.NAMA',
        'trnjadi.JUMLAH AS totalbarang')
        ->orderBy('trnsales.BUKTI', 'asc')
        ->get();
        return response()->json($penjualan);
    }

    public function getSummaryCustomer(Request $request)
    {
        $idSales = $request->ID_SALES;
        $tanggalAwal = DateTime::createFromFormat('d-m-Y', $request->TANGGALAWAL);
        $tanggalAkhir = DateTime::createFromFormat('d-m-Y', $request->TANGGALAKHIR);
        $penjualan = trnsales::where('trnsales.KDTRN', 12)
        ->where('trnsales.ID_SALESMAN', $idSales)
        ->whereBetween('trnsales.TANGGAL', [$tanggalAwal->format('Y-m-d'), $tanggalAkhir->format('Y-m-d')])
        ->join('customer', 'trnsales.ID_CUSTOMER', 'customer.ID_CUSTOMER')
        ->select(
        'trnsales.ID_CUSTOMER',
        DB::raw('SUM(trnsales.JUMLAH) AS total_jumlah'),
        DB::raw('SUM(trnsales.NETTO) AS total_netto'),
        DB::raw('SUM(trnsales.DISCOUNT) AS total_diskon'),
        'customer.NAMA')
        ->groupBy('trnsales.ID_CUSTOMER', 'customer.NAMA')
        ->get();
        return response()->json($penjualan);
    }

    public function getSummaryBarang(Request $request)
    {
        $idSales = $request->ID_SALES;
        $tanggalAwal = DateTime::createFromFormat('d-m-Y', $request->TANGGALAWAL);
        $tanggalAkhir = DateTime::createFromFormat('d-m-Y', $request->TANGGALAKHIR);
        $penjualan = trnsales::where('trnsales.KDTRN', 12)
        ->where('trnsales.ID_SALESMAN', $idSales)
        ->whereBetween('trnsales.TANGGAL', [$tanggalAwal->format('Y-m-d'), $tanggalAkhir->format('Y-m-d')])
        ->join('trnjadi', function ($join) {
            $join->on('trnsales.KDTRN', '=', 'trnjadi.KDTRN')
                ->on('trnsales.BUKTI', '=', 'trnjadi.BUKTI')
                ->on('trnsales.PERIODE','=','trnjadi.PERIODE');
        })
        ->join('barang', 'trnjadi.ID_BARANG', 'barang.ID_BARANG')
        ->select(
        DB::raw('SUM(trnjadi.QTY) AS total_qty'),
        'trnjadi.ID_BARANG',
        'barang.NAMASINGKAT',
        DB::raw('SUM(trnjadi.JUMLAH) AS total_jumlah'),)
        ->groupBy('trnjadi.ID_BARANG', 'barang.NAMASINGKAT')
        ->get();
        return response()->json($penjualan);
    }
}
