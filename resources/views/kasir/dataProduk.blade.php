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
                            <div class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Produk</th>
                                        <th>Jumlah</th>
                                        <th>Stok</th>
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
                                                        value="{{ $item->id }}" name="barang_id" hidden></td>
                                                <td>{{ $item->formatRupiah('harga') }}<input class="form-control"
                                                        type="text" value="{{ $item->harga }}" name="harga"
                                                        hidden></td>
                                                <td style="width: 15%"><input class="form-control jumlah" type="number"
                                                        name="jumlah" id="jumlah" value="1" min="1"
                                                        max="{{ $item->stok }}">
                                                </td>
                                                @if ($item->stok > 0)
                                                    <td>{{ $item->stok }}<input type="text"
                                                            value="{{ $item->stok }}" hidden><input
                                                            class="form-control" type="text" value="1" hidden>
                                                    </td>
                                                @endif
                                                @if ($item->stok <= 0)
                                                    <td><span class="text-danger">Stok Habis</span></td>
                                                @endif
                                                @if ($item->stok <= 0)
                                                    <td><button type="submit" id="tambah"
                                                            class="btn btn-sm btn-success" disabled><i
                                                                class="fa fa-plus"></i></button></td>
                                                @endif
                                                @if ($item->stok > 0)
                                                    <td><button type="submit" id="tambah"
                                                            class="btn btn-sm btn-success"><i
                                                                class="fa fa-plus"></i></button></td>
                                                @endif
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>