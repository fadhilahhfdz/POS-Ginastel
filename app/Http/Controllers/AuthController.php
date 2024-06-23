<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        $user = User::all();
        return view('auth.register', compact('user'));
    }

    public function store(Request $request) {
        try {
            $sekarang = Carbon::now();
            $tahun_bulan = $sekarang->year . $sekarang->month;
            $cek = User::count();

            if ($cek == 0) {
                $urut = 10001;
                $kode = 'SN' . $tahun_bulan . $urut;
            } else {
                $ambil = User::all()->last();
                $urut = (int)substr($ambil->kode, -5) + 1;
                $kode = 'SN' . $tahun_bulan . $urut;
            }

            $request->validate([
                'nama' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'role' => 'required|string',
            ]);

            $user = new User;
            $user->kode = $kode;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            return redirect('login')->with('sukses', 'Registrasi Berhasil!, Silahkan login');
        } catch (\Exception $e) {
            return redirect('register')->with('status', 'Registrasi gagal:( ' . $e->getMessage());
        }
    }

    public function login() {
        return view('auth.login');
    }

    public function roleLogin(Request $request): RedirectResponse {
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/kasir/dashboard');
            }
        } else {
            return back()->with('gagal', 'Email atau Password salah');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    // public function forgotPassword() {
    //     return view('auth.forgotPassword');
    // }
}