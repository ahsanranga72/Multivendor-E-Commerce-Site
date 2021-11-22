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

    public function markDelivered(SubOrder $suborder)
    {
        $suborder->status = 'completed';
        $suborder->save();

        //check if all suborders complete
        $pendingSubOrders = $suborder->order->subOrders()->where('status','!=', 'completed')->count();

        if($pendingSubOrders == 0) {
            $suborder->order()->update(['status'=>'completed']);
        }

        return redirect('/seller/orders')->withMessage('Order marked complete');
    }

    public function render()
    { 
        $seller = Seller::where('user_id', auth()->user()->id)->first();
        $orders = SubOrder::where(['seller_id'=> $seller->id])->paginate(10);

        return view('livewire.seller.seller-order-component',['orders'=>$orders])->layout('layouts.base');
    }
}
