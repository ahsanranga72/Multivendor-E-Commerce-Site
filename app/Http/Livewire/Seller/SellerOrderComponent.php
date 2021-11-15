<?php

namespace App\Http\Livewire\Seller;

use App\Models\Order;
use App\Models\SubOrder;
use Livewire\Component;

class SellerOrderComponent extends Component
{
    public function render()
    {
        $orders = SubOrder::where('seller_id', auth()->id())->get();

        return view('livewire.seller.seller-order-component',['orders'=>$orders])->layout('layouts.base');
    }
}
