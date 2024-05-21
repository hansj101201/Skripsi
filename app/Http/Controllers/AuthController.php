<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\depo;
use App\Models\role;
use Illuminate\Http\Request;
use App\Models\users;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class AuthController extends Controller
{
    //
    public function index()
    {
        if (getIdDepo() === '000') {
            $depo = depo::all();
            $role = role::all();
        } else {
            $depo = depo::where("ID_DEPO", getIdDepo());
            $role = role::where("ROLE_ID", ">", 2)->get();
        }

        return view("layout.setup.user.index", compact("depo", "role"));
    }

    public function datatable()
    {
        $user = users::leftjoin("depo", "user.ID_DEPO", "depo.ID_DEPO")
            ->select("user.*", DB::raw("IFNULL(depo.NAMA, null) AS nama_depo"));

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
                return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="' . $row->ID_USER . '"data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp';
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function getDetail($id)
    {
        $user = users::where("ID_USER", $id)->get();
        return response()->json($user);
    }
    public function login(Request $request)
    {
        return view("auth.login");
    }

    public function showLink(Request $request)
    {
        return view('auth.email');
    }

    public function sendResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email',
        'iduser' => 'required',], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid',
            'iduser.required' => 'ID Pengguna harus diisi.',
        ]);

        $user = DB::table('user')->where('EMAIL', $request->email)->where('ID_USER',$request->iduser)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Id User dengan email tersebut tidak ditemukan','iduser' => 'Id User dengan email tersebut tidak ditemukan']);
        }

        $token = Str::random(60);

        // Store token
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Send token to user via email
        Mail::send('email.password_reset', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('status', 'Link untuk reset password sudah dikirim di email');
    }

    public function showForm(Request $request, $token)
    {
        $resetEntries = DB::table('password_resets')->get();
        foreach ($resetEntries as $resetEntry) {
            if (Hash::check($token, $resetEntry->token)) {
                // Jika cocok, token valid, lanjutkan ke tindakan berikutnya
                if (Carbon::parse($resetEntry->created_at)->addMinutes(15)->isPast()) {
                    DB::table('password_resets')->where('token', $resetEntry->token)->delete();
                    return redirect()->route('login')->withErrors(['token' => 'Expired token']);
                } else {
                    return response()->view('auth.reset', ['token' => $token])->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
                }
            }
        }
        return redirect()->route('login')->withErrors(['token' => 'Invalid token']);
    }

    public function resetPassword(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.required' => 'Password harus diisi.',
            'password.min:8'=> 'Password harus minimum 8 character'
        ]);
        $resetEntries = DB::table('password_resets')->get();

        // Loop melalui setiap entri
        foreach ($resetEntries as $resetEntry) {
            // Verifikasi apakah hash token dari URL cocok dengan hash token yang disimpan di database
            if (Hash::check($request->token, $resetEntry->token)) {
                $email = $resetEntry->email;
            }
        }

        $reset = DB::table('password_resets')->where('email', $email)->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['token' => 'Invalid token']);
        }
        DB::table('user')->where('EMAIL', $email)->update(['PASSWORD' => Hash::make($request->password)]);
        DB::table('password_resets')->where('email', $email)->delete();
        return redirect()->route('login')->with('status', 'Password berhasil direset!')->withHeaders([
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    public function changePasswordView(Request $request)
    {
        return response()->view("auth.changePassword");
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password sekarang harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min:8'=> 'Password harus minimum 8 character'
        ]);

        // Memeriksa apakah kata sandi saat ini sesuai
        if (!Hash::check($request->current_password, Auth::user()->PASSWORD)) {
            return redirect()->back()->withErrors(['current_password' => 'Password sekarang salah.']);
        }

        // Mengubah kata sandi
        DB::table('user')->where('ID_USER', Auth::user()->ID_USER)->update(['PASSWORD' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
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
                'PASSWORD' => 'required',
                'EMAIL' => 'required|email',
                'NOMOR_HP' => 'required',
                'ROLE_ID' => 'required',
                'ACTIVE' => 'required',
                'ID_DEPO' => 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $data['PASSWORD'] = Hash::make($request->PASSWORD);
            $data['TGLENTRY'] = $currentDateTime;
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;

            users::create($data);
            return response()->json(['success' => true, 'message' => 'Data User Sudah Di Simpan.']);
        } else {
            $existingRecord = Users::where('ID_USER', $request->ID_USER)->join('depo', 'user.ID_DEPO', 'depo.ID_DEPO')->select('depo.NAMA')->get();
            return response()->json(['success' => false, 'message' => 'User sudah ada di depo ', 'existing_record' => $existingRecord]);
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
                'ROLE_ID' => 'required',
                'ID_DEPO' => 'sometimes',
                'ACTIVE' => 'sometimes',
            ]);
            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            $users->update($validatedData);
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false, 'error' => 'Data gagal diperbarui'], 404);
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
