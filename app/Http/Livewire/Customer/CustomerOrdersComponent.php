<?php

namespace App\Http\Livewire\Customer;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerOrdersComponent extends Component
{
    use WithPagination;
    public function render()
    {
        $orders = Order::where('user_id', Auth::user()->id)->paginate(10);
        return view('livewire.customer.customer-orders-component', ['orders'=>$orders])->layout('layouts.base');
    }
}
