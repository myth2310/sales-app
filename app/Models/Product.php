<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'bonus', 'price','garansi','stok', 'discount', 'is_preorder','preorder_quantity','stok_preorder', 'available_date',  'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
