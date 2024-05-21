<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\customer;
use App\Models\salesman;
use App\Models\trnsales;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class customerController extends Controller
{
    //

    public function index(){
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        if(getIdDepo()=='000'){
            $sales = salesman::where('ACTIVE',1)->get();
        } else {
            $sales = salesman::where('ID_DEPO',getIdDepo())->where('ACTIVE',1)->get();
        }
        return view('layout.setup.customer.index', compact('sales','apiKey'));
    }

    public function datatable(){
        $idDepo = getIdDepo();
        if($idDepo=='000'){
            $customer = customer::all();
        } else {
            $customer = customer::join('salesman','customer.ID_SALES','salesman.ID_SALES')
            ->where('salesman.ID_DEPO',getIdDepo())->select('customer.*');
        }

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
        return response()->json($customer);
    }
    public function store(Request $request){
        $existingRecord = customer::where('ID_CUSTOMER', $request['ID_CUSTOMER'])->first();
        if(!$existingRecord){
            $validatedData = $request->validate([
                'ID_CUSTOMER' => 'required',
                'NAMA' => 'required',
                'EMAIL' => 'required',
                'ALAMAT' => 'sometimes',
                'KOTA' => 'sometimes',
                'KODEPOS' => 'sometimes',
                'TELEPON' => 'sometimes',
                'PIC' => 'sometimes',
                'NOMOR_HP' => 'sometimes',
                'ALAMAT_KIRIM' => 'sometimes',
                'KOTA_KIRIM' => 'sometimes',
                'KODEPOS_KIRIM' => 'sometimes',
                'TELEPON_KIRIM' => 'sometimes',
                'PIC_KIRIM' => 'sometimes',
                'NOMOR_HP_KIRIM' => 'sometimes',
                'ACTIVE'=> 'sometimes',
                'ID_SALES'=> 'required',
                'TITIK_GPS'=> 'sometimes',
            ]);
            $data = $validatedData;
            $currentDateTime = date('Y-m-d H:i:s');
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            $data['TGLENTRY'] = $currentDateTime;
            customer::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
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
                'EMAIL' => 'required',
                'ALAMAT' => 'sometimes',
                'KOTA' => 'sometimes',
                'KODEPOS' => 'sometimes',
                'TELEPON' => 'sometimes',
                'PIC' => 'sometimes',
                'NOMOR_HP' => 'sometimes',
                'ALAMAT_KIRIM' => 'sometimes',
                'KOTA_KIRIM' => 'sometimes',
                'KODEPOS_KIRIM' => 'sometimes',
                'TELEPON_KIRIM' => 'sometimes',
                'PIC_KIRIM' => 'sometimes',
                'NOMOR_HP_KIRIM' => 'sometimes',
                'ACTIVE'=> 'sometimes',
                'ID_SALES'=> 'required',
                'TITIK_GPS'=> 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            $customer->update($validatedData);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_CUSTOMER)
    {
        $trnsalesCount = trnsales::where('ID_CUSTOMER', $ID_CUSTOMER)->count();
        $customer = customer::where('ID_CUSTOMER', $ID_CUSTOMER)->first();
        if ($trnsalesCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus customer karena sudah digunakan dalam transaksi'], 422);
        } else if (!$customer) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $customer->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }

    public function getCustomerActive(){
        $customer = customer::where('ACTIVE',1)->get();
        return response()->json($customer);
    }

    public function getCustomerAll(){
        $customer = customer::all();
        return response()->json($customer);
    }

    //untuk api
    public function getCustomer(Request $request){
        $idSales = $request->ID_SALES;
        $customer = customer::where('ACTIVE',1)->where('ID_SALES',$idSales)->get();
        return response()->json($customer);
    }
}
