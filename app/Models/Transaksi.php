<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'transaksi';

    // Tentukan kolom yang boleh diisi secara massal
    protected $fillable = ['tanggal', 'total_harga'];

    // Relasi dengan model DetailTransaksi
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
    