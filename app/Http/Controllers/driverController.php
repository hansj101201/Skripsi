<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\driver;
use App\Models\depo;
use App\Models\trnjadi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class driverController extends Controller
{
    public function index () {
        $depo = depo::all();
        return view('layout.setup.driver.index', compact('depo'));
    }

    public function datatable(){
        $driver = driver::join("depo","driver.ID_DEPO","depo.ID_DEPO")
        ->select("driver.*", "depo.NAMA AS nama_depo");
        return DataTables::of($driver)
        ->editColumn("ID_DEPO", function ($row) {
            return $row->nama_depo;
        })
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_DRIVER.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_DRIVER.'" data-jenis="driver" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id){
        $driver = driver::where("ID_DRIVER",$id)->get();
        return response()->json($driver);
    }
    public function store(Request $request)
    {
        // Periksa apakah ID yang akan ditambahkan sudah ada dalam database
        $existingRecord = driver::where('ID_DRIVER', $request['ID_DRIVER'])->first();
        // dd($request->all());
        // dd($existingRecord);
        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_DRIVER' => 'required',
                'NAMA' => 'required',
                'EMAIL' => 'nullable|email',
                'NOMOR_HP'=> 'sometimes',
                'ID_DEPO'=> 'required',
                'ACTIVE' => 'sometimes'
            ]);

            // dd($validatedData);
            $data = $validatedData;


            $currentDateTime = date('Y-m-d H:i:s');
            $data['TGLENTRY'] = $currentDateTime;
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            // ID tidak ada dalam database, maka buat entitas baru
            driver::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            // ID sudah ada dalam database, kirim respons JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {

        $driver = driver::where('ID_DRIVER', $request['ID_DRIVER'])->first();

        // dd($driver);
        if ($driver) {
            $validatedData = $request->validate([
                'ID_DRIVER' => 'required',
                'NAMA' => 'required',
                'EMAIL' => 'nullable|email',
                'NOMOR_HP'=> 'sometimes',
                'ID_DEPO'=> 'required',
                'ACTIVE' => 'sometimes'
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['TGLEDIT'] = $currentDateTime;
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            // dd($validatedData);
            $driver->update($validatedData);

            // dd($driver);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan KDJADI tersebut tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_DRIVER)
    {
        $trnjadiCount = trnjadi::where('ID_DRIVER', $ID_DRIVER)->count();
        if ($trnjadiCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus driver karena sudah digunakan dalam transaksi'], 422);
        }

        $driver = driver::where('ID_DRIVER', $ID_DRIVER)->first();
        if (!$driver) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $driver->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
