<div class="modal fade" id="data-produk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div style="overflow-y: scroll; max-height: 400px;">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $item)
                                        <tr>
                                            <form action="/{{ auth()->user()->role }}/kasir/store" method="POST">
                                                @csrf
                                                <td>{{ $loop->iteration }}<input class="form-control" type="text"
                                                        value="{{ $kode }}" name="kode_transaksi" hidden></td>
                                                <td>{{ $item->nama }}<input class="form-control" type="text"
                                                        value="{{ $item->id }}" name="id_produk" hidden></td>
                                                <td>{{ $item->formatRupiah('harga') }}<input class="form-control"
                                                        type="text" value="{{ $item->harga }}" name="harga"
                                                        hidden></td>
                                                <td style="width: 15%"><input class="form-control jumlah" type="number"
                                                        name="jumlah" id="jumlah" value="1" min="1"
                                                        max="{{ $item->stok }}">
                                                </td>
                                                <td><button type="submit" id="tambah"
                                                    class="btn btn-sm btn-success"><i
                                                        class="fa fa-plus"></i></button></td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>