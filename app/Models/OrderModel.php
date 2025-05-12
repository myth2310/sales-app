<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id_product',
        'kode_pembayaran',
    ];
    

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product'); 
    }
}
