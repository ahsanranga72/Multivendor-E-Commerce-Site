<?php

namespace App\Http\Livewire\Seller;

use App\Models\Seller;
use App\Models\SubOrder;
use Carbon\Carbon;
use Livewire\Component;

class SellerDashboardComponent extends Component
{
    public function render()
    {
        $seller = Seller::where('user_id', auth()->user()->id)->first();
        $orders = SubOrder::where(['seller_id'=> $seller->id])->orderBy('created_at', 'DESC')->get()->take(10);
        $totalSales = SubOrder::where(['seller_id'=> $seller->id])->where('status', 'completed')->count();
        $totalRevenue = SubOrder::where(['seller_id'=> $seller->id])->where('status', 'completed')->sum('grand_total');
        $todaySales = SubOrder::where(['seller_id'=> $seller->id])->where('status', 'completed')->whereDate('created_at',Carbon::today())->count();
        $todayRevenue = SubOrder::where(['seller_id'=> $seller->id])->where('status', 'completed')->whereDate('created_at',Carbon::today())->sum('grand_total');

        return view('livewire.seller.seller-dashboard-component',[
            'orders'=>$orders,
            'totalSales'=>$totalSales,
            'totalRevenue'=>$totalRevenue,
            'todaySales'=>$todaySales,
            'todayRevenue'=>$todayRevenue
        ])->layout('layouts.base');
    }
}
