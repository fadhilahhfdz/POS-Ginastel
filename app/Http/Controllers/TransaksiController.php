<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = Transaksi::orderBy('tanggal', 'desc')->get();

        return view('laporan.index', compact('transaksi'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($kodeTransaksi)
    {
        $data = DetailTransaksi::where('kode_transaksi', $kodeTransaksi)->get();

        return view('transaksi.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    public function print($kode_transaksi)
    {
        $id_transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        $transaksi = Transaksi::find($id_transaksi->id);
        $detail_transaksi = DetailTransaksi::where('kode_transaksi', $kode_transaksi)->get();

        $pdf = Pdf::loadView('laporan.print', compact('transaksi', 'detail_transaksi'));
        return $pdf->stream();
    }

    public function totalPrint($dari, $sampai)
    {
        $sampaiTanggal = Carbon::parse($sampai)->addDays(1)->format('Y-m-d');
        $transaksi = Transaksi::whereBetween('tanggal', [$dari, $sampaiTanggal])->get();

        $all = 0;
        foreach($transaksi as $data) {
            $all += $data->total;
        }

        $total = number_format($all, 0, ',', '.');

        $pdf = Pdf::loadView('laporan.totalPrint', compact('transaksi', 'dari', 'sampai', 'total'));
        return $pdf->stream();
    }

    public function cari(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $tanggalSampai = Carbon::parse($sampai)->addDays(1)->format('Y-m-d');
        
        $transaksi = Transaksi::whereBetween('tanggal', [$dari, $tanggalSampai])->get();
        
        return view('laporan.cari',compact('transaksi', 'dari', 'sampai'));
    }
}
