<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\gudang;
use App\Models\salesman;
use App\Models\depo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class salesmanController extends Controller
{
    public function index () {

        $gudang = gudang::whereNotIn('id_gudang', function($query) {
                $query->select('id_gudang')
                    ->from('salesman');
            })
            ->select('gudang.*')
            ->get();
        $depo = depo::all();
        return view('layout.setup.salesman.index', compact('depo','gudang'));
    }

    public function datatable(){
        $salesman = salesman::join("depo","salesman.ID_DEPO","depo.ID_DEPO")
        ->select("salesman.*", "depo.NAMA AS nama_depo");
        return DataTables::of($salesman)
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_SALES.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_SALES.'" data-jenis="salesman" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id){
        $salesman = salesman::where("ID_SALES",$id)->get();
        return response()->json($salesman);
    }
    public function store(Request $request)
    {
        // Periksa apakah ID yang akan ditambahkan sudah ada dalam database
        $existingRecord = salesman::where('ID_SALES', $request['ID_SALES'])->first();
        // dd($request->all());
        // dd($existingRecord);
        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_SALES' => 'required',
                'NAMA' => 'required',
                'EMAIL' => 'nullable|email',
                'PASSWORD' => 'required',
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
            salesman::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            // ID sudah ada dalam database, kirim respons JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {

        $salesman = salesman::where('ID_SALES', $request['ID_SALES'])->first();

        // dd($salesman);
        if ($salesman) {
            $validatedData = $request->validate([
                'ID_SALES' => 'required',
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
            $salesman->update($validatedData);

            // dd($salesman);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan KDJADI tersebut tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_SALES)
    {
        $salesman = salesman::where('ID_SALES', $ID_SALES)->first();
        if (!$salesman) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $salesman->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
