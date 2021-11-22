<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public function category()
    {
        return $this->belongsTo(Catagory::class, 'category_id');
    }
    public function shop()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
