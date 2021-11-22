<?php

namespace App\Http\Livewire\Seller;

use App\Models\SubOrder;
use Livewire\Component;

class SellerOrderShowComponent extends Component
{
    public function render(SubOrder $order)
    {
        $items = $order->items;
        return view('livewire.seller.seller-order-show-component',['items'=>$items])->layout('layouts.base');
    }
}
