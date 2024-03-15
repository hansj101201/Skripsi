<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\gudang;
use App\Models\trnjadi;
use App\Models\trnsales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class transferGudangController extends Controller
{
    //
    public function index(){
        $barang = barang::all();
        $gudang = gudang::all();
        return view("layout.transaksi.transferGudang.index", compact('gudang','barang'));
    }

    public function datatable(){
        $trnsales = trnsales::where('KDTRN','15')
        ->where('NOPERMINTAAN',null)
        ->join('gudang as G1', 'trnsales.ID_GUDANG', 'G1.ID_GUDANG')
        ->join('gudang as G2', 'trnsales.ID_GUDANG_TUJUAN', 'G2.ID_GUDANG')
        ->select('trnsales.*', 'G1.NAMA as NAMA_GUDANG', 'G2.NAMA as NAMA_GUDANG_TUJUAN');

        // dd($trnsales);
        return DataTables::of($trnsales)
        ->editColumn('ID_GUDANG', function ($row) {
            return $row->NAMA_GUDANG;
        })
        ->editColumn('ID_GUDANG_TUJUAN', function ($row) {
            return $row->NAMA_GUDANG_TUJUAN;
        })
        ->addColumn('action', function ($row) {
            // Initialize the action buttons HTML
            $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#detailModal" data-bukti="'.$row->BUKTI.'" data-tanggal="'.$row->TANGGAL.'" data-nomorpermintaan="'.$row->NOPERMINTAAN.'" data-periode="'.$row->PERIODE.'"><span class="fas fa-eye"></span></button>';
            // Check if $row->jumlah is zero
            if ($row->JUMLAH == 0) {
                // If $row->jumlah is zero, add the delete button
                $actionButtons .= '&nbsp;<button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
            }
            // Return the action buttons HTML
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($bukti,$periode){
        $data = trnjadi::where('KDTRN','15')
        ->where('PERIODE', $periode)
        ->where('BUKTI',$bukti)
        ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','trnjadi.ID_SATUAN','satuan.ID_SATUAN')
        ->select('trnjadi.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan')
        ->orderBy('NOMOR','asc')
        ->get();

        return response()->json($data);
    }

    public function postDetailTransferGudang(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $data = $request->data;
            // dd($data);
            foreach ($data as $item) {
                trnjadi::where('KDTRN', '15')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                ]);

                trnjadi::where('KDTRN', '05')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                ]);
            }
            DB::commit();

            // Mengembalikan respons JSON untuk memberi tahu klien bahwa pembaruan berhasil
            return response()->json(['success'=>true,'message' => 'Update successful']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi dan kirim respons kesalahan
            DB::rollBack();
            return response()->json(['success'=>false,'message' => 'Error occurred while updating data'], 500);
        }
    }

    public function getSatuan(Request $request){
        $barangId = $request->input('barang_id');

    // Assuming you have a model named Barang, you can retrieve the corresponding satuan
        $barang = Barang::where('ID_BARANG',$barangId)
        ->join('satuan','satuan.ID_SATUAN','barang.ID_SATUAN')
        ->select('barang.NAMA','satuan.NAMA AS nama_satuan','barang.ID_SATUAN')
        ->first();

        // Check if barang exists
        if ($barang) {
            // If barang exists, return the satuan
            return response()->json(['satuan' => $barang->nama_satuan,'nama'=> $barang->NAMA,'id_satuan'=>$barang->ID_SATUAN]);
        } else {
            // If barang does not exist, return an error response
            return response()->json(['error' => 'Barang not found'], 404);
        }
    }
}
