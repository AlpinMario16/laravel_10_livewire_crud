<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
