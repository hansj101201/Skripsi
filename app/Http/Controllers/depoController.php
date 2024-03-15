<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\depo;
use App\Models\driver;
use App\Models\gudang;
use App\Models\salesman;
use App\Models\trnsales;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class depoController extends Controller
{
    //
    public function index () {

        return view('layout.setup.depo.index');
    }

    public function datatable () {
        $depo = depo::all();
        return DataTables::of($depo)
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_DEPO.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_DEPO.'" data-jenis="supplier" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])

        ->make(true);
    }

    public function getDetail ($id) {
        $depo = depo::where("ID_DEPO", $id)->get();
        return response()->json($depo);
    }
    public function store(Request $request)
    {
        // Periksa apakah ID yang akan ditambahkan sudah ada dalam database
        $existingRecord = depo::where('ID_DEPO', $request['ID_DEPO'])->first();

        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_DEPO' => 'required',
                'NAMA' => 'required',
                'LOKASI' => 'sometimes',
                'ACTIVE' => 'sometimes'
            ]);
            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['TGLENTRY'] = $currentDateTime;
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            // ID tidak ada dalam database, maka buat entitas baru
            depo::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            // ID sudah ada dalam database, kirim respons JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {

        $depo = depo::where('ID_DEPO', $request['ID_DEPO'])->first();

        // dd($barang);
        if ($depo) {
            $validatedData = $request->validate([
                'ID_DEPO' => 'required',
                'NAMA' => 'required',
                'LOKASI' => 'sometimes',
                'ACTIVE' => 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['TGLEDIT'] = $currentDateTime;
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            // dd($validatedData);
            $depo->update($validatedData);

            // dd($barang);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan KDJADI tersebut tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_DEPO)
    {
        $salesmanCount = salesman::where('ID_DEPO', $ID_DEPO)->count();

        // Check if there are any associated records in the gudang table
        $gudangCount = gudang::where('ID_DEPO', $ID_DEPO)->count();

        $driverCount = driver::where('ID_DEPO', $ID_DEPO)->count();

        $trnSalesCount = trnsales::where('ID_DEPO', $ID_DEPO)->count();

        // If there are associated records in either table, prevent deletion
        if ($salesmanCount > 0 || $gudangCount > 0 || $driverCount > 0 || $trnSalesCount > 0) {
            // If there are associated records, return an error response
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus depo karena terdapat salesman atau gudang yang terkait'], 422);
        }

        $depo = depo::where('ID_DEPO', $ID_DEPO)->first();
        if (!$depo) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $depo->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
