@extends('layouts.main')
@section('title', ' - Dashboard')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid alert alert-success">
        <p class="m-0">Hallo <span class="font-weight-bold">{{auth()->user()->nama}}</span>, Kamu Login Sebagai <span class="font-weight-bold">{{auth()->user()->role}}</span>.</p>
      </div>

      @if (auth()->user()->role == 'admin')
        <div class="section-body">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow-none">
                <span class="info-box-icon bg-secondary"><i class="fas fa-box"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Produk</span>
                  <span class="info-box-number">{{$produk->count()}}</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow-none">
                <span class="info-box-icon bg-secondary"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Transaksi</span>
                  <span class="info-box-number">{{$transaksi->count()}}</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow-none">
                <span class="info-box-icon bg-secondary"><i class="fas fa-shopping-bag"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Transaksi Hari Ini</span>
                  <span class="info-box-number">{{$transaksi_hari_ini->count()}}</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow-none">
                <span class="info-box-icon bg-secondary"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total User</span>
                  <span class="info-box-number">{{$user->count()}}</span>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header bg-white">
                  <h4>Detail Transaksi</h4>
                </div>
                <div class="card-body p-2 table-responsive">
                  <table class="table table-hover" id="table">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($detail as $item)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                              <td>{{$item->kode_transaksi}}</td>
                              <td>{{$item->produk}}</td>
                              <td>{{$item->formatRupiah('harga')}}</td>
                              <td>{{$item->jumlah}}</td>
                              <td>{{$item->formatRupiah('total')}}</td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
      @if (auth()->user()->role == 'kasir')
      <div class="section-body">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-none">
              <span class="info-box-icon bg-secondary"><i class="fas fa-chart-line"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Transaksi</span>
                <span class="info-box-number">{{$transaksi->count()}}</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-none">
              <span class="info-box-icon bg-secondary"><i class="fas fa-shopping-bag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Transaksi Hari Ini</span>
                <span class="info-box-number">{{$transaksi_hari_ini->count()}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
    </section>
    <!-- /.content -->
</div>
@endsection
@push('script')
<script>
  $(document).ready(function () {
        $('#table').DataTable();
    });

    $(document).ready(function () {
        $('#data-table').DataTable();
    });
</script>
@endpush