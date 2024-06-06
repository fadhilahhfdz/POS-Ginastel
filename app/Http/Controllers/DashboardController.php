<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
        $user = User::all();
        // $produk = Produk::all();
        // $transaksi = Transaksi::all();
        // $detail = TransaksiDetail::orderBy('created_at', 'desc')->get();
        // $stok_kosong = Barang::where('stok', 0)->get();
        // $today = Carbon::now()->format('Y-m-d');
        // $transaksi_hari_ini = Transaksi::whereDate('tanggal', $today)->get();

        return view('auth.dashboard', compact('user'));
        // return view('dashboard.index', compact('produk', 'transaksi', 'detail', 'transaksi_hari_ini', 'stok_kosong'));
    }
}
