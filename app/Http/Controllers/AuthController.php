<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\depo;
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
        $depo = depo::all();
        return view("layout.setup.user.index", compact("depo"));
    }

    public function datatable(){
        $user = users::leftjoin("depo","user.ID_DEPO","depo.ID_DEPO")
        ->select("user.*",DB::raw("IFNULL(depo.NAMA, null) AS nama_depo"));
        return DataTables::of($user)
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
            return redirect('login')->with('pesan', 'Gagal Login');
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
                'ACTIVE'=> 'required',
                'ID_DEPO'=> 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $data['PASSWORD'] = Hash::make($request->PASSWORD);
            $data['TGLENTRY'] = $currentDateTime;
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;

            users::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal Register.']);
        }
    }

    public function update(Request $request)
    {

        $users = users::where('ID_USER', $request['ID_USER'])->first();

        // dd($users);
        if ($users) {
            $validatedData = $request->validate([
                'ID_USER' => 'required',
                'NAMA' => 'required',
                'EMAIL' => 'sometimes',
                'NOMOR_HP' => 'sometimes',
                'ID_DEPO' => 'sometimes',
                'ACTIVE' => 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            // dd($validatedData);
            $users->update($validatedData);

            // dd($users);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan KDJADI tersebut tidak ditemukan'], 404);
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
