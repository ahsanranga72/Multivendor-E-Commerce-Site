<?php

namespace App\Http\Livewire\Seller;

use App\Models\Order;
use App\Models\Seller;
use App\Models\SubOrder;
use Livewire\Component;
use Livewire\WithPagination;

class SellerOrderComponent extends Component
{
    public $seller;
    use WithPagination;
    public function render()
    {
        $seller = Seller::where('user_id', auth()->user()->id)->first();
        $orders = SubOrder::where(['seller_id'=> $seller->id])->paginate(10);

        return view('livewire.seller.seller-order-component',['orders'=>$orders])->layout('layouts.base');
    }
}
