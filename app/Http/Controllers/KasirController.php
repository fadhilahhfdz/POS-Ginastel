<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Kasir;
use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::all();
        $kasir = Kasir::all();
        $sekarang = Carbon::now();
        $format_tanggal = $sekarang->year . $sekarang->month;
        $cek = Transaksi::count();

        if ($cek == 0) {
            $urut = 10000001;
            $kode = 'KT' . $format_tanggal . $urut;
        } else {
            $ambil = Transaksi::all()->last();
            $urut = (int)substr($ambil->kode_transaksi, -8) +1;
            $kode = 'KT' . $format_tanggal . $urut;
        }

        return view('kasir.index', compact('produk', 'kasir', 'kode'));
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
        $user = Auth::user();

        $data = $request->all();

        $subtotal = $data['harga'] * $data['jumlah'];

        $produkAda = Kasir::where('id_produk', $request->id_produk)->first();

        if ($produkAda) {
            return redirect('/' . $user->role . '/kasir')->with('warning', 'Barang sudah tersedia');
        } else {
            $kasir = new Kasir;
            $kasir->kode_transaksi = $request->kode_transaksi;
            $kasir->id_produk = $request->id_produk;
            $kasir->harga = $request->harga;
            $kasir->jumlah = $request->jumlah;
            $kasir->total = $subtotal;
            $kasir->save();
        }

        return redirect('/' . $user->role . '/kasir');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kasir $kasir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kasir $kasir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $data = $request->all();

            $subtotal = $data['harga'] * $data['jumlah'];

            $kasir = Kasir::find($id);
            $kasir->jumlah = $request->jumlah;
            $kasir->total = $subtotal;
            $kasir->update();

            return redirect('/' . $user->role . '/kasir');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $kasir = Kasir::find($id);
        $kasir->delete();

        return redirect('/' . $user->role . '/kasir');
    }

    public function deleteAll() 
    {
        $user = Auth::user();

        Kasir::truncate();

        return redirect('/' . $user->role . '/kasir');
    }

    public function pembayaran(Request $request, $kode_transaksi)
    {
        $user = Auth::user();

        $kasir = Kasir::all();

        if ($kasir->isEmpty()) {
            return redirect('/' . $user->role . '/kasir')->with('gagal', 'Transaksi gagal');
        } else {
            try {
                $request->validate([
                    'kode_transaksi' => 'required|string|max:100',
                    'total' => 'required|numeric',
                    'bayar' => 'required|numeric',
                    'kembalian' => 'required|numeric',
                    'kode_kasir' => 'required|string|max:100',
                ]);

                $tanggalSekarang = now('Asia/Jakarta')->format('Y-m-d H:i:s');;
                $transaksi = new Transaksi;
                $transaksi->kode_transaksi = $request->kode_transaksi;
                $transaksi->total = $request->total;
                $transaksi->bayar = $request->bayar;
                $transaksi->kembalian = $request->kembalian;
                $transaksi->kode_kasir = $request->kode_kasir;
                $transaksi->tanggal = $tanggalSekarang;
                $transaksi->save();

                foreach($kasir as $data) {
                    $produk = Produk::find($data->id_produk);

                    DetailTransaksi::create([
                            'kode_transaksi' => $data->kode_transaksi,
                            'produk' => $produk->nama,
                            'harga' => $data->harga,
                            'jumlah' => $data->jumlah,
                            'total' => $data->total,
                    ]);

                    Kasir::truncate();
                }
            } catch(\Exception $e) {
                return redirect('/' . $user->role . '/kasir')->with('gagal', 'Transaksi gagal ' . $e->getMessage());
            }

            return redirect('/' . $user->role . '/kasir')->with('berhasil', $kode_transaksi);
        }
    }
}