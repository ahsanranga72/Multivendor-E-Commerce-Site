<?php

namespace App\Http\Livewire\Seller;

use App\Models\Order;
use Livewire\Component;

class SellerOrderComponent extends Component
{
    public function render()
    {
        $orders = Order::wherehas('items.shop', function($q){
            $q->where('seller_id', auth()->id());
        })->get();
        return view('livewire.seller.seller-order-component',['orders'=>$orders])->layout('layouts.base');
    }
}
