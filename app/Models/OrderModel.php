<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id_product',
        'kode_pembayaran',
        'name_pelanggan',
        'no_telpon',
        'alamat',
        'status',
        'email',
        'name_seles',
    ];
    
}
