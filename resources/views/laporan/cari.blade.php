@extends('layouts.main')
@section('title', ' - Laporan')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success">
                        <p><span class="font-weight-bold">Laporan Tanggal: {{$dari}} Sampai {{$sampai}}</span></p>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-white justify-content-center">
                            <form action="/{{auth()->user()->role}}/laporan/cari">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group d-flex">
                                            <label class="mr-1" for="nama">Dari</label>
                                            <input type="date" class="form-control" name="dari" value="{{$dari}}"
                                                max="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group d-flex">
                                            <label class="mr-1" for="nama">Sampai</label>
                                            <input type="date" class="form-control" name="sampai" value="{{$sampai}}"
                                                max="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success"><i
                                                    class="fa fa-search"></i> Cari</button>
                                            <a href="/{{auth()->user()->role}}/laporan/{{$dari}}/{{$sampai}}/print" class="btn btn-sm btn-danger" target="_blank"><i
                                                    class="fa fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body p-2">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Kode Kasir</th>
                                        <th>Total</th>
                                        <th>Bayar</th>
                                        <th>Kembalian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->kode_transaksi}}</td>
                                        <td>{{$item->tanggal}}</td>
                                        <td>{{$item->kode_kasir}}</td>
                                        <td>{{$item->formatRupiah('total')}}</td>
                                        <td>{{$item->formatRupiah('bayar')}}</td>
                                        <td>{{$item->formatRupiah('kembalian')}}</td>
                                        <td>
                                            <a href="/{{auth()->user()->role}}/laporan/{{$item->kode_transaksi}}/print" target="_blank"
                                                class="btn btn-sm btn-outline-danger"><i class="fa fa-print"></i> Print</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });

</script>
@endpush