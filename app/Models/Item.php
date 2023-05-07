<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_barang',
        'deskripsi',
        'gambar',
        'stok',
        'harga_beli',
        'harga_jual'
    ];
}
