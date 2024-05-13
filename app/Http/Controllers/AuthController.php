<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\depo;
use App\Models\role;
use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AuthController extends Controller
{
    //
    public function index()
    {
        if(getIdDepo() === '000'){
            $depo = depo::all();
            $role = role::all();
        } else {
            $depo = depo::where("ID_DEPO",getIdDepo());
            $role = role::where("ROLE_ID",">",2)->get();
        }

        return view("layout.setup.user.index", compact("depo","role"));
    }

    public function datatable(){
        $user = users::leftjoin("depo","user.ID_DEPO","depo.ID_DEPO")
        ->select("user.*",DB::raw("IFNULL(depo.NAMA, null) AS nama_depo"));

        $idDepo = getIdDepo();
        if ($idDepo === '000') {
            $usersQuery = $user;
        } else {
            $usersQuery = $user->where('user.ID_DEPO', $idDepo);
        }
        return DataTables::of($usersQuery)
        ->editColumn("ACTIVE", function ($row) {
            return $row->ACTIVE == 1 ? "Ya" : "Tidak";
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_USER.'"data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id){
        $user = users::where("ID_USER",$id)->get();
        return response()->json($user);
    }
    public function login(Request $request)
    {
        return view("auth.login");
    }
    public function doLogin(Request $request)
    {
        $request->validate([
            'ID_USER' => 'required',
            'PASSWORD' => 'required',
        ], [
            'ID_USER.required' => 'ID Pengguna harus diisi.',
            'PASSWORD.required' => 'Kata Sandi harus diisi.',
        ]);

        $credential = [
            "ID_USER" => $request->ID_USER,
            "password" => $request->PASSWORD,
        ];
        if (Auth::attempt($credential)) {
            $user = Auth::user();

            if ($user->ACTIVE == 1) {
                // Jika user aktif, redirect ke dashboard
                return redirect("dashboard");
            } else {
                // Jika user tidak aktif, kembalikan ke halaman login dengan pesan
                Auth::logout();
                return redirect('login')->with('pesan', 'Akun Anda dinonaktifkan.');
            }
            // ini adalah function super kita untuk membaca data siapa yang lagi login sekarang
        } else {
            return redirect('login')->with('pesan', 'Invalid User Id / Password');
        }
    }

    public function register(Request $request)
    {
        $existingRecord = Users::where('ID_USER', $request->ID_USER)->first();

        if (!$existingRecord) {
            $data = $request->validate([
                'ID_USER' => 'required',
                'NAMA' => 'required',
                'PASSWORD'=> 'required',
                'EMAIL'=> 'required|email',
                'NOMOR_HP'=> 'required',
                'ROLE_ID'=> 'required',
                'ACTIVE'=> 'required',
                'ID_DEPO'=> 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $data['PASSWORD'] = Hash::make($request->PASSWORD);
            $data['TGLENTRY'] = $currentDateTime;
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;

            users::create($data);
            return response()->json(['success' => true, 'message' => 'Data User Sudah Di Simpan.']);
        } else {
            $existingRecord = Users::where('ID_USER', $request->ID_USER)->join('depo','user.ID_DEPO','depo.ID_DEPO')->select('depo.NAMA')->get();
            return response()->json(['success' => false, 'message' => 'User sudah ada di depo ','existing_record' => $existingRecord]);
        }
    }

    public function update(Request $request)
    {

        $users = users::where('ID_USER', $request['ID_USER'])->first();
        if ($users) {
            $validatedData = $request->validate([
                'ID_USER' => 'required',
                'NAMA' => 'required',
                'EMAIL' => 'sometimes',
                'NOMOR_HP' => 'sometimes',
                'ROLE_ID'=> 'required',
                'ID_DEPO' => 'sometimes',
                'ACTIVE' => 'sometimes',
            ]);
            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            $users->update($validatedData);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data gagal diperbarui'], 404);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect("login");
    }
}
