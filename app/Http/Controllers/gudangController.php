<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\gudang;
use App\Models\depo;
use App\Models\trnjadi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class gudangController extends Controller
{
    public function index () {
        return view('layout.setup.gudang.index');
    }

    public function datatable(){
        if (getIdDepo() == '000'){
            $gudang = gudang::join("depo","gudang.ID_DEPO","depo.ID_DEPO")
            ->select("gudang.*", "depo.NAMA AS nama_depo");
        } else {
            $gudang = gudang::where('gudang.ID_DEPO',getIdDepo())
            ->join("depo","gudang.ID_DEPO","depo.ID_DEPO")
            ->select("gudang.*", "depo.NAMA AS nama_depo");
        }

        return DataTables::of($gudang)
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_GUDANG.'"data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_GUDANG.'" data-jenis="gudang" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id) {
        $gudang = gudang::where("ID_GUDANG", $id)->get();
        return response()->json($gudang);
    }

    public function store(Request $request)
    {
        $existingRecord = gudang::where('ID_GUDANG', $request['ID_GUDANG'])->first();
        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_GUDANG' => 'required',
                'NAMA' => 'required',
                'ID_DEPO' => 'required',
                'ACTIVE' => 'sometimes'
            ]);
            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            $data['TGLENTRY'] = $currentDateTime;
            gudang::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {

        $gudang = gudang::where('ID_GUDANG', $request['ID_GUDANG'])->first();

        // dd($barang);
        if ($gudang) {
            $validatedData = $request->validate([
                'ID_GUDANG' => 'required',
                'NAMA' => 'required',
                'ID_DEPO' => 'required',
                'ACTIVE' => 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            $gudang->update($validatedData);

            // dd($barang);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_GUDANG)
    {
        $trnjadiCount = trnjadi::where('ID_GUDANG', $ID_GUDANG)->count();
        $gudang = gudang::where('ID_GUDANG', $ID_GUDANG)->first();
        if ($trnjadiCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus gudang karena sudah digunakan dalam transaksi'], 422);
        } else if (!$gudang) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $gudang->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }

    public function getGudang($depo){
        $gudang = gudang::where('ID_DEPO',$depo)
        ->where('ACTIVE',1)
        ->whereNotIn('ID_GUDANG', function($query) {
            $query->select('ID_GUDANG')
                ->from('salesman');
        })
        ->select('gudang.*')
        ->get();
        return response()->json($gudang);
    }

    public function getSalesGudang($depo){
        $gudang = gudang::where('ID_DEPO',$depo)->get();
        return response()->json($gudang);
    }

    public function getSalesGudangAll(){
        $gudang = gudang::where('ID_DEPO',getIdDepo())->get();
        return response()->json($gudang);
    }

    public function getGudangActive(){
        // dd(getIdDepo());
        $gudang = gudang::where('ID_DEPO',getIdDepo())
        ->where('ACTIVE',1)
        ->whereNotIn('ID_GUDANG', function($query) {
            $query->select('ID_GUDANG')
                ->from('salesman');
        })
        ->select('gudang.*')->get();
        return response()->json($gudang);
    }

    public function getGudangAll(){
        $gudang = gudang::where('ID_DEPO',getIdDepo())
        ->whereNotIn('ID_GUDANG', function($query) {
            $query->select('ID_GUDANG')
                ->from('salesman');
        })
        ->select('gudang.*')
        ->get();
        return response()->json($gudang);
    }

    //untuk api
    public function getListGudang(Request $request)
    {
        $idDepo = $request->ID_DEPO;
        $gudang = gudang::where('ID_DEPO',$idDepo)
        ->where('ACTIVE',1)
        ->whereNotIn('ID_GUDANG', function($query) {
            $query->select('ID_GUDANG')
                ->from('salesman');
        })
        ->select('gudang.*')
        ->get();
        return response()->json($gudang);
    }
}
