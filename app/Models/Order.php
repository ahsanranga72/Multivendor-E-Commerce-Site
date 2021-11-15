<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table="orders";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')->withPivot('quantity', 'price');
    }

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class);
    }

    public function generateSubOrders()
    {
        $orderItems = $this->items;

        foreach($orderItems->groupBy('seller_id') as $sellerId => $products) {

            $seller = Seller::find($sellerId);

            $suborder = $this->subOrders()->create([
                'order_id'=> $this->id,
                'seller_id'=> $seller->user_id ?? 1,
                'grand_total'=> $products->sum('pivot.price'),
                'item_count'=> $products->count()
            ]);

            foreach($products as $product) {
                $suborder->items()->attach($product->id, ['price' => $product->pivot->price, 'quantity' => $product->pivot->quantity]);
            }

        }

    }

    public function markDeclined()
    {

        $this->status = 'decline';
        $this->save();

        $this->subOrders()->update(['status'=>'decline']);
    }
}
