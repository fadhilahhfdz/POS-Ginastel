<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::all();

        $sekarang = Carbon::now();
        $tahun_bulan = $sekarang->year . $sekarang->month;
        $cek = Produk::count();

        if ($cek == 0) {
            $urut = 10001;
            $kode = 'GNS' . $tahun_bulan . $urut;
        } else {
            $ambil = Produk::all()->last();
            $urut = (int)substr($ambil->kode, -5) +1;
            $kode = 'GNS' . $tahun_bulan . $urut;
        }

        return view('produk.index', compact('produk', 'kode'));
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
                'kode' => 'required|string|max:100',
                'nama' => 'required|string|max:100',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
            ]);

            $produk = new Produk;
            $produk->kode = $request->kode;
            $produk->nama = $request->nama;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->save();

            return redirect('/admin/produk')->with('sukses', 'Data berhasil di simpan');
        } catch (\Exception $e) {
            return redirect('/admin/produk')->with('gagal', 'Gagal menyimpan data ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $produk = Produk::find($id);

        // return view('produk.view', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::find($id);

        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:100',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
            ]);

            $produk = Produk::find($id);
            $produk->nama = $request->nama;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->update();

            return redirect('/admin/produk')->with('sukses', 'Data berhasil di edit');
        } catch (\Exception $e) {
            return redirect('/admin/produk')->with('gagal', 'Gagal edit data ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return redirect('/admin/produk')->with('sukses', 'Berhasil menghapus data');
    }
}