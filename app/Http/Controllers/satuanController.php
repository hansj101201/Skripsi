<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\satuan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class satuanController extends Controller
{
    //
    public function index () {
        return view('layout.setup.satuan.index');
    }

    public function datatable(){
        $satuan =satuan::all();
        return DataTables::of($satuan)
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_SATUAN.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_SATUAN.'" data-jenis="satuan" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail ($id) {
        $satuan =satuan::where("ID_SATUAN",$id)->get();
        return response()->json($satuan);
    }
    public function store(Request $request)
    {

        // Periksa apakah ID yang akan ditambahkan sudah ada dalam database
        $existingRecord = satuan::where('ID_SATUAN', $request['ID_SATUAN'])->first();
        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_SATUAN' => 'required',
                'NAMA' => 'required',
            ]);
            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            $data['TGLENTRY'] = $currentDateTime;
            satuan::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {
        // dd($request ->all());
        $satuan = satuan::where('ID_SATUAN', $request ['ID_SATUAN'])->first();

        // dd($satuan);
        if ($satuan) {
            $validatedData = $request->validate([
                'ID_SATUAN' => 'required',
                'NAMA' => 'required',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            $satuan->update($validatedData);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan ID tersebut tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_SATUAN)
    {
        $barangCount = barang::where('ID_SATUAN', $ID_SATUAN)->count();

        if ($barangCount > 0) {
            // If there are associated records, return an error response
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus satuan karena terdapat barang yang terkait'], 422);
        }
        $satuan = satuan::where('ID_SATUAN', $ID_SATUAN)->first();
        if (!$satuan) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $satuan->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
