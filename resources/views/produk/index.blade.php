@extends('layouts.main')
@section('title', ' - Produk')
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
                            <li class="breadcrumb-item active">Produk</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Produk</h3>

                                <div class="card-tools">
                                    <div class="card-header-form">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#form-tambah"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-2">
                                <table class=" table table-hover text-nowrap" id="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Produk</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produk as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->kode }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>Rp{{ $item->formatRupiah('harga') }}</td>
                                                <td>
                                                    <form action="/{{ auth()->user()->role }}/produk/{{ $item->id }}"
                                                        id="delete-form">
                                                        <a href="/{{ auth()->user()->role }}/produk/{{ $item->id }}/edit"
                                                            class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            id="{{ $item->kode }}" data-id="{{ $item->id }}"
                                                            onclick="confirmDelete(this)"><i class="fas fa-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @include('produk.form')
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });

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

        var data_anggota = $(this).attr('data-id');

        function confirmDelete(button) {

            event.preventDefault()
            const id = button.getAttribute('data-id');
            const kode = button.getAttribute('id');

            swal({
                    title: 'Apakah anda ingin menghapusnya ?',
                    text: 'Anda akan menghapus data: "' + kode +
                        '". Ketika anda pencet OK, maka data akan terhapus permanen!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        const form = document.getElementById('delete-form');
                        // Setelah mengkonfirmasi penghapusan, Anda bisa mengirim form ke server
                        form.action = '/{{ auth()->user()->role }}/produk/' +
                        id; // Ubah aksi form sesuai dengan ID yang sesuai
                        form.submit();
                    }
                });
        }
    </script>
@endpush
