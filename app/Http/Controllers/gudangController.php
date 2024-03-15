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

        // $processedData = $this->processGudangData($gudang);
        $depo = depo::all();
        return view('layout.setup.gudang.index', compact('depo'));
    }

    public function datatable(){
        $gudang = gudang::join("depo","gudang.ID_DEPO","depo.ID_DEPO")
        ->select("gudang.*", "depo.NAMA AS nama_depo");
        return DataTables::of($gudang)
        ->editColumn("ID_DEPO", function ($row) {
            return $row->nama_depo;
        })
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
        // Periksa apakah ID yang akan ditambahkan sudah ada dalam database
        $existingRecord = gudang::where('ID_GUDANG', $request['ID_GUDANG'])->first();

        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_GUDANG' => 'required',
                'NAMA' => 'required',
                'ALAMAT' => 'sometimes',
                'ID_DEPO' => 'required',
                'ACTIVE' => 'sometimes'
            ]);
            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['TGLENTRY'] = $currentDateTime;
            // ID tidak ada dalam database, maka buat entitas baru
            gudang::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            // ID sudah ada dalam database, kirim respons JSON dengan pesan kesalahan
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
                'ALAMAT' => 'sometimes',
                'ID_DEPO' => 'required',
                'ACTIVE' => 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['TGLEDIT'] = $currentDateTime;
            // dd($validatedData);
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
        if ($trnjadiCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus gudang karena sudah digunakan dalam transaksi'], 422);
        }

        $gudang = gudang::where('ID_GUDANG', $ID_GUDANG)->first();
        if (!$gudang) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $gudang->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
