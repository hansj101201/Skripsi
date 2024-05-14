<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\supplier;
use App\Models\trninvorder;
use App\Models\trnsales;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class supplierController extends Controller
{
    //

    public function index () {
        return view('layout.setup.supplier.index');
    }

    public function datatable(){
        $supplier = supplier::all();
        return DataTables::of($supplier)
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_SUPPLIER.'" data-nama="'.$row->NAMA.'" data-alamat="'.$row->ALAMAT.'" data-kota="'.$row->KOTA.'" data-telepon="'.$row->TELEPON.'" data-npwp="'.$row->NPWP.'" data-aktif="'.$row->ACTIVE.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_SUPPLIER.'" data-jenis="supplier" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id) {
        $supplier = supplier::where("ID_SUPPLIER",$id)->get();
        return response()->json($supplier);
    }
    public function store(Request $request)
    {
        $existingRecord = supplier::where('ID_SUPPLIER', $request['ID_SUPPLIER'])->first();
        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_SUPPLIER' => 'required',
                'NAMA' => 'required',
                'ALAMAT' => 'required',
                'KOTA'=> 'required',
                'TELEPON'=> 'required',
                'NPWP'=> 'sometimes',
                'ACTIVE' => 'sometimes'
            ]);
            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            $data['TGLENTRY'] = $currentDateTime;
            supplier::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {

        // dd($request->all());
        // dd($request['ID_SUPPLIER']);
        $supplier = supplier::where('ID_SUPPLIER', $request['ID_SUPPLIER'])->first();

        // dd($supplier);
        if ($supplier) {

            $validatedData = $request->validate([
                'ID_SUPPLIER' => 'required',
                'NAMA' => 'required',
                'ALAMAT' => 'required',
                'KOTA'=> 'required',
                'TELEPON'=> 'required',
                'NPWP'=> 'sometimes',
                'ACTIVE' => 'sometimes'
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            // dd($validatedData);
            $supplier->update($validatedData);

            // dd($barang);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan KDJADI tersebut tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_SUPPLIER)
    {
        $trnInvOrderCount = trninvorder::where('ID_SUPPLIER', $ID_SUPPLIER)->count();
        $trnSalesCount = trnsales::where('ID_SUPPLIER', $ID_SUPPLIER)->count();

        if ($trnInvOrderCount > 0 || $trnSalesCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus supplier karena sudah digunakan dalam transaksi'], 422);
        }
        $supplier = supplier::where('ID_SUPPLIER', $ID_SUPPLIER)->first();
        if (!$supplier) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $supplier->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }
}
