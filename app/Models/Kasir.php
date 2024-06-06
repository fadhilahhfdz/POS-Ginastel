<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;


class Kasir extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kode_transaksi',
        'id_produk',
        'harga',
        'jumlah',
        'total',
    ];

    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}