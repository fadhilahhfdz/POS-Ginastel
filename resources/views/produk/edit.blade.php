@extends('layouts.main')
@section('title', ' - Edit')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Produk</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Produk</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h4>Edit Data Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="/{{ auth()->user()->role }}/produk/{{ $produk->id }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col md-6">
                                    <div class="form-group">
                                        <label for="kode">Kode Produk :</label>
                                        <input type="text" class="form-control" name="kode"value="{{ $produk->kode }}"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Produk :</label>
                                        <input type="text" class="form-control" name="nama"
                                            value="{{ $produk->nama }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga Produk :</label>
                                        <input type="text" class="form-control" name="harga" id="harga"
                                            value="{{ $produk->harga }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="stok">Stok :</label>
                                        <input type="number" class="form-control" name="stok"
                                            value="{{ $produk->stok }}">
                                    </div>
                                </div>
                            </div>
                            <a href="/{{ auth()->user()->role }}/produk" class="btn btn-danger">
                                Kembali</a>
                            <button type="submit" class="btn btn-primary">
                                Edit</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.jumlah').on('input', function() {
                if ($(this).val() < 0) {
                    $(this).val(0);
                }
            });
        })

        // mengambil elemen input
        var harga = document.getElementById('harga');

        // menambah event listener setiap kali input
        harga.addEventListener('input', function() {
            // Mengganti nilai input hanya karakter angka
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endpush
