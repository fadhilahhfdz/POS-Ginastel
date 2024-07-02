@extends('layouts.main')
@section('title', ' - Penjualan')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Penjualan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Penjualan</li>
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
                                <h3 class="card-title">Penjualan Kasir</h3>
                                <div class="card-tools">
                                    <div class="card-header-form">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#data-produk"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="kasir">Nama Kasir :</label>
                                            <select class="custom-select" name="kode_kasir">
                                                <option value="{{ auth()->user()->kode }}">
                                                    {{ auth()->user()->nama }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kode">Kode Transaksi :</label>
                                            <input type="text" id="kode-transaksi" class="form-control"
                                                value="{{ $kode }}" name="kode_transaksi" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group float-right">
                                            <label class="text-primary" for="Total Belanja">Subtotal</label>
                                            <div class="input-group-prepend">
                                                <h1 class="text-primary mr-2">Rp<br></h1>
                                                <input class="d-none" type="text" id="total" value="0"
                                                    name="total">
                                                <h1 class="text-primary" id="label-total">0</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rounded" style="overflow-y: scroll; height: 300px;">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Harga Produk</th>
                                                <th>Jumlah</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kasir as $item)
                                                <tr>
                                                    <td>{{ $item->produk->nama }}</td>
                                                    <form
                                                        action="/kasir/kasir/{{ $item->id }}/{{ $item->id_produk }}/edit"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <td class="harga" value="{{ $item->harga }}">
                                                            {{ $item->formatRupiah('harga') }}
                                                            <input type="text" value="{{ $item->harga }}" name="harga"
                                                                hidden>
                                                        </td>
                                                        <td class="jumlah" value="{{ $item->jumlah }}" style="width: 20%">
                                                            <input type="number" class="form-control"
                                                                value="{{ $item->jumlah }}" name="jumlah" min="1">
                                                        </td>
                                                        <td class="total" value="{{ $item->total }}">
                                                            {{ $item->formatRupiah('total') }}</td>
                                                        <td>
                                                            <div class="aksi d-flex">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-warning mr-2 text-white"><i
                                                                        class="fa fa-edit"></i></button>
                                                            </div>  ,l
                                                    </form>
                                                    <form action="/{{ auth()->user()->role }}/kasir/{{ $item->id }}"
                                                        id="delete-form">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" id="bayar-modal" class="btn m-1 btn-primary float-right"
                                    data-toggle="modal" data-target="#form-bayar">Bayar</button>
                                <a href="/{{ auth()->user()->role }}/kasir/hapus/semua"
                                    class="btn m-1 btn-danger float-right">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('kasir.dataProduk')
            @include('kasir.formPembayaran')
        </section>
    </div>
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
        });

        var inputAngka = document.getElementById('bayar');

        // Menambahkan event listener untuk setiap kali ada input
        inputAngka.addEventListener('input', function() {
            // Mengganti nilai input hanya dengan karakter angka
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function hitungKembali() {
            // Ambil nilai dari input "Di Bayar"
            var diBayar = document.getElementById('bayar').value;

            // Konversi nilai menjadi angka
            var diBayarAngka = parseFloat(diBayar) || 0;

            // Ambil nilai total belanja dari label
            var total = document.getElementById('total').value;
            var belanja = parseFloat(total) || 0;

            // Hitung kembali
            var kembali = diBayarAngka - belanja;

            // Tampilkan nilai kembali pada input "Kembali"
            document.getElementById('kembali').value = kembali.toLocaleString('id-ID');
            document.getElementById('kembalian').value = kembali;
            total.value = kembali;

            // Optionally, you can show a warning message if the payment is insufficient
            if (kembali < 0) {
                document.getElementById('warning-message').style.display = 'block';
            } else {
                document.getElementById('warning-message').style.display = 'none';
            }
        }
        document.getElementById('bayar').addEventListener('input', hitungKembali);
    </script>
    <script>
        function simpan() {
            event.preventDefault()
            var bayar = parseFloat(document.getElementById('bayar').value) || 0;
            var kembali = parseFloat(document.getElementById('kembali').value) || 0;
            form_bayar = document.getElementById('form-penjualan');
            if (kembali < 0 || bayar == 0) {
                iziToast.warning({
                    title: 'Transaksi Gagal',
                    message: 'Jumlah Bayar Kurang !',
                    position: 'topRight'
                });
            } else {
                swal({
                        title: 'Simpan Transaksi ?',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((bayar) => {
                        if (bayar) {
                            form_bayar.submit();
                        } else {
                            iziToast.success({
                                title: 'Transaksi Dibatalkan',
                                position: 'topRight'
                            });
                        }
                    });
            }
        }
    </script>
    <script>
        function hitungTotal() {
            var total = document.querySelectorAll('#table tbody td.total');
            var label_total = document.getElementById('label-total');
            var sub_total = document.getElementById('total');
            var label_total_bayar = document.getElementById('label-total-bayar');
            var sub_total_bayar = document.getElementById('total-bayar');
            var bayarButton = document.getElementById('bayar-modal');

            // Inisialisasi variabel total
            var grandTotal = 0;

            // Iterasi melalui setiap elemen dan menjumlahkannya
            total.forEach(function(element) {
                var totalValue = parseFloat(element.getAttribute('value')) || 0;
                grandTotal += totalValue;
            });

            if (grandTotal == 0) {
                bayarButton.setAttribute('disabled', true);
            } else {
                bayarButton.removeAttribute('disabled');
            }

            // Tampilkan hasilnya di label_total dengan format mata uang Rupiah
            label_total.innerHTML = grandTotal.toLocaleString('id-ID');
            sub_total.value = grandTotal;
            label_total_bayar.innerHTML = grandTotal.toLocaleString('id-ID');
            sub_total_bayar.value = grandTotal;
        }
    </script>
    <script>
        function setDibayarkan(setbayar) {
            bayar = parseFloat(document.getElementById('bayar').value) || 0;
            var total = 0;

            if (setbayar == 0) {
                bayar.value = "";
            } else {
                if (bayar == 0) {
                    var hasil = total += setbayar;
                } else {
                    var hasil = total + setbayar + bayar;
                }
            }

            document.getElementById('bayar').value = hasil;
            hitungKembali();
        }
    </script>
@endpush
