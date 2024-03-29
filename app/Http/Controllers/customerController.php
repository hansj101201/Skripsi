<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\customer;
use App\Models\salesman;
use App\Models\trnjadi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class customerController extends Controller
{
    //

    public function index(){
        $sales = salesman::all();
        return view('layout.setup.customer.index', compact('sales'));
    }

    public function datatable(){
        $customer = customer::all();
        return DataTables::of($customer)
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_CUSTOMER.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_CUSTOMER.'" data-jenis="customer" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id){
        $customer = customer::where('ID_CUSTOMER',$id)->get();
        // dd($customer);
        return response()->json($customer);
    }
    public function store(Request $request){
        $existingRecord = customer::where('ID_CUSTOMER', $request['ID_CUSTOMER'])->first();

        if(!$existingRecord){
            $validatedData = $request->validate([
                'ID_CUSTOMER' => 'required',
                'NAMA' => 'required',
                'NAMACUST' => 'sometimes',
                'ALAMAT' => 'required',
                'KOTA' => 'required',
                'KODEPOS' => 'sometimes',
                'NEGARA' => 'sometimes',
                'NAMAUP' => 'sometimes',
                'ACTIVE'=> 'sometimes',
                'BAGIAN' => 'sometimes',
                'CRDLIMIT' => 'sometimes',
                'TERMKREDIT' => 'sometimes',
                'TERMBULAN' => 'sometimes',
                'TERMHARI' => 'sometimes',
                'REKENING' => 'sometimes',
                'PERWAKILAN' => 'sometimes',
                'ID_SALES'=> 'required',
                'NPWP' => 'sometimes',
                'ALAMAT_KIRIM' => 'sometimes',
            ]);

            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['TGLENTRY'] = $currentDateTime;
            // ID tidak ada dalam database, maka buat entitas baru
            customer::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            // ID sudah ada dalam database, kirim respons JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }

    }

    public function update(Request $request){
        // dd($request->all());
        $customer = customer::where('ID_CUSTOMER', $request['ID_CUSTOMER'])->first();
        // dd($customer);

        if($customer){
            $validatedData = $request->validate([
                'ID_CUSTOMER' => 'required',
                'NAMA' => 'required',
                'NAMACUST' => 'sometimes',
                'ALAMAT' => 'required',
                'KOTA' => 'required',
                'KODEPOS' => 'sometimes',
                'NEGARA' => 'sometimes',
                'NAMAUP' => 'sometimes',
                'ACTIVE'=> 'required',
                'BAGIAN' => 'sometimes',
                'CRDLIMIT' => 'sometimes',
                'TERMKREDIT' => 'sometimes',
                'TERMBULAN' => 'sometimes',
                'TERMHARI' => 'sometimes',
                'REKENING' => 'sometimes',
                'PERWAKILAN' => 'sometimes',
                'ID_SALES'=> 'required',
                'NPWP' => 'sometimes',
                'ALAMAT_KIRIM' => 'sometimes',
            ]);

            // dd($validatedData);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['TGLEDIT'] = $currentDateTime;
            // ID tidak ada dalam database, maka buat entitas baru
            $customer->update($validatedData);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_CUSTOMER)
    {
        $trnjadiCount = trnjadi::where('ID_CUSTOMER', $ID_CUSTOMER)->count();
        $customer = customer::where('ID_CUSTOMER', $ID_CUSTOMER)->first();
        if ($trnjadiCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus customer karena sudah digunakan dalam transaksi'], 422);
        } else if (!$customer) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $customer->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
