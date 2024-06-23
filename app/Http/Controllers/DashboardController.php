<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->role == 'kasir') {
            $user = Auth::user();
            $transaksi = Transaksi::where('kode_kasir', $user->kode)->orderBy('tanggal', 'desc')->get();
            $today = Carbon::now()->format('Y-m-d');
            $transaksi_hari_ini = Transaksi::where('kode_kasir', $user->kode)->whereDate('tanggal', $today)->get();

            return view('auth.dashboard', compact('transaksi', 'transaksi_hari_ini'));
        } else {
            $user = User::all();
            $produk = Produk::all();
            $transaksi = Transaksi::all();
            $detail = DetailTransaksi::orderBy('created_at', 'desc')->get();
            $today = Carbon::now()->format('Y-m-d');
            $transaksi_hari_ini = Transaksi::whereDate('tanggal', $today)->get();
            
            return view('auth.dashboard', compact('user', 'produk', 'transaksi', 'detail', 'transaksi_hari_ini'));
        }

    }
}
