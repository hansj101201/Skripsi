<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\gudang;
use App\Models\salesman;
use App\Models\depo;
use App\Models\trnsales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class salesmanController extends Controller
{
    public function index () {
        $depo = depo::where('ID_DEPO','!=','000')->get();
        return view('layout.setup.salesman.index', compact('depo'));
    }

    public function datatable(){
        $idDepo = getIdDepo();
        if ($idDepo == '000'){
            $salesman = salesman::join("depo","salesman.ID_DEPO","depo.ID_DEPO")
            ->select("salesman.*", "depo.NAMA AS nama_depo");
        } else {
            $salesman = salesman::where('salesman.ID_DEPO',$idDepo)
            ->join("depo","salesman.ID_DEPO","depo.ID_DEPO")
            ->select("salesman.*", "depo.NAMA AS nama_depo");
        }
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
                'ID_GUDANG'=> 'required',
                'ACTIVE' => 'sometimes'
            ]);

            // dd($validatedData);
            $data = $validatedData;


            $currentDateTime = date('Y-m-d H:i:s');
            $data['PASSWORD'] = Hash::make($request->PASSWORD);
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
                'ID_GUDANG'=> 'required',
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
        $trnsales = trnsales::where('ID_SALESMAN', $ID_SALES)->count();
        $salesman = salesman::where('ID_SALES', $ID_SALES)->first();

        if ($trnsales > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus sales karena sudah digunakan dalam transaksi'], 422);
        } else if (!$salesman) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $salesman->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }

    //untuk api
    public function doLogin(Request $request){
        $request->validate([
            'ID_SALES' => 'required',
            'PASSWORD' => 'required',
        ]);

        $credential = [
            "ID_SALES" => $request->ID_SALES,
            "password" => $request->PASSWORD,
        ];
        if (Auth::guard('salesman')->attempt($credential)) {
            $salesman = salesman::where('ID_SALES', $request->ID_SALES)
                        ->where('active', 1)
                        ->select('ID_SALES','NAMA','EMAIL','NOMOR_HP','ID_DEPO','ID_GUDANG')
                        ->get();
            if ($salesman->isEmpty()) {
                return response()->json(['message' => 'Login failed'], 401);
            }
            return response()->json(['salesman' => $salesman, 'message' => 'Login success'], 200);
        } else {
            return response()->json(['message' => 'Login failed'], 401);
        }
    }

    public function cekEmail(Request $request){
        $email = $request->EMAIL;

        $cek = salesman::where('EMAIL',$email)->get();

        if($cek->isEmpty()){
            return response()->json(['message' => 'email tidak ditemukan'],404);
        } else {
            return response()->json(['message' => 'data ditemukan'],200);
        }
    }

    public function resetPassword(Request $request){
        $email = $request->EMAIL;
        $password = $request->PASSWORD;

        $passwordHashed = Hash::make($password);
        $data = salesman::where('EMAIL',$email)->first();
        $data->update(['PASSWORD' => $passwordHashed]);
        return response()->json(['message' => 'Berhasil mengubah password'],200);
    }

    public function changePassword(Request $request){
        $email = $request->EMAIL;
        $password = $request->PASSWORD;
        $passwordlama = $request->PASSWORDLAMA;

        $credential = [
            "EMAIL" => $email,
            "password" => $passwordlama,
        ];
        if (Auth::guard('salesman')->attempt($credential)) {
            $passwordHashed = Hash::make($password);
            $data = salesman::where('EMAIL',$email)->first();
            $data->update(['PASSWORD' => $passwordHashed]);
            return response()->json(['message' => 'Berhasil mengubah password'],200);
        } else {
            return response()->json(['message' => 'Password Lama Salah'], 401);
        }

    }
}
