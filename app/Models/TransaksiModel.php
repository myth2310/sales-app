<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; 

    protected $fillable = [
        'kode_pembayaran',
        'name_pelanggan',
        'no_telpon',
        'alamat',
        'email',
        'name_seles',
        'metode_pembayaran',
        'uang_dibayar',
        'total_belanja',
        'kembalian',
        'status',
        'waktu_pembayaran',
    ];

}
