<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DetailTransaksi extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'detail_transaksi';

    // Tentukan kolom yang boleh diisi secara massal
    protected $fillable = ['transaksi_id', 'product_id', 'jumlah', 'subtotal'];

    // Relasi dengan model Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
