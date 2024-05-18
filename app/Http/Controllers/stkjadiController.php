<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class stkjadiController extends Controller
{
    public function getSaldoBarang(Request $request){
        $tahun = substr($request->input('tanggal'), -4);
        $saldo = DB::table('stkjadi')
            ->select('SALDO')
            ->where('ID_GUDANG', $request->input('gudang'))
            ->where('ID_DEPO', getIdDepo())
            ->where('ID_BARANG', $request->input('barang_id'))
            ->where('TAHUN', $tahun)
            ->first();

            // dd($saldo);
        $saldoValue = $saldo ? $saldo->SALDO : 0;
        return response()->json($saldoValue);
    }


    //untuk api
    public function getStockSales(Request $request){

        $idGudang = $request->ID_GUDANG; // "12-04-2024"
        $stok = DB::table('stkjadi')
            ->where('stkjadi.ID_GUDANG', $idGudang)
            ->join('barang', 'stkjadi.ID_BARANG', '=', 'barang.ID_BARANG')
            ->where('barang.ACTIVE',1)
            ->where('stkjadi.SALDO','!=',0)
            ->join('satuan', 'barang.ID_SATUAN', 'satuan.ID_SATUAN')
            ->select('barang.*', 'stkjadi.SALDO AS saldo', 'satuan.NAMA AS nama_satuan')
            ->get();

        return response()->json($stok);
    }

    //untuk api
    public function getStockPenjualan(Request $request){
        $Tanggal = DateTime::createFromFormat('d-m-Y', $request->TANGGAL);
        $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $tanggalFormatted = $Tanggal->format('Y-m-d');

        $idGudang = $request->ID_GUDANG;

        $stok = DB::table('stkjadi')
            ->where('stkjadi.ID_GUDANG', $idGudang)
            ->join('barang', 'stkjadi.ID_BARANG', '=', 'barang.ID_BARANG')
            ->where('barang.ACTIVE', 1)
            ->join('satuan', 'barang.ID_SATUAN', 'satuan.ID_SATUAN')
            ->join('harga', function ($join) use ($tanggalFormatted) {
                $join->on('barang.ID_BARANG', '=', 'harga.ID_BARANG')
                    ->whereRaw('harga.MULAI_BERLAKU = (SELECT MAX(MULAI_BERLAKU) FROM harga WHERE harga.ID_BARANG = barang.ID_BARANG AND harga.MULAI_BERLAKU <= ?)', [$tanggalFormatted]);
            })
            ->select('barang.ID_BARANG', 'harga.HARGA', DB::raw('MAX(harga.MULAI_BERLAKU) AS max_mulai_berlaku'), 'barang.NAMASINGKAT', 'satuan.NAMA AS nama_satuan', 'stkjadi.SALDO AS saldo')
            ->groupBy('barang.ID_BARANG', 'harga.HARGA', 'barang.NAMASINGKAT', 'satuan.NAMA', 'stkjadi.SALDO')
            ->orderBy('barang.ID_BARANG', 'desc')
            ->get();

        return response()->json($stok);
    }

}
