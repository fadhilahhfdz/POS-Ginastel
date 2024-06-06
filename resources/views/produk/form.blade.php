<div class="modal fade" id="form-tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/{{ auth()->user()->role }}/produk/store" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col md-6">
                            <div class="form-group">
                                <label for="kode">Kode Produk :</label>
                                <input type="text" name="kode" class="form-control" value="{{ $kode }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Produk :</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga Produk:</label>
                                <input type="text" name="harga" class="form-control jumlah" id="harga">
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok :</label>
                                <input type="number" name="stok" class="form-control jumlah">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>