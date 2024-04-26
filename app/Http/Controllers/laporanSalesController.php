<?php

namespace App\Http\Controllers;

use App\Models\trnsales;
use DateTime;
use Illuminate\Http\Request;

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
        ->get()
        ->groupBy('BUKTI');

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
        ->get()
        ->groupBy('BUKTI');

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
        ->get()
        ->groupBy('BUKTI');

        return response()->json($permintaan);
    }
}
