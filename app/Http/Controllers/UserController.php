<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

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
        return view('user.index', compact('user', 'kode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode' => 'required|string|max:255',
                'nama' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'role' => 'required|in:admin,kasir',
            ]);

            $user = new User;
            $user->kode = $request->kode;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            return redirect('/admin/user')->with('sukses', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect('/admin/userr')->with('gagal', 'Data Gaga disimpan. '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($request->password == null) {
                $user->nama = $request->nama;
                $user->email = $request->email;
                $user->update();
            } else {
                $user->nama = $request->nama;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->update();
            }

            return redirect('/admin/user')->with('sukses', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect('/admin/user')->with('gagal', 'Data gagal di edit, '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect('/admin/user')->with('sukses', 'Data berhasil dihapus');
    }
}
