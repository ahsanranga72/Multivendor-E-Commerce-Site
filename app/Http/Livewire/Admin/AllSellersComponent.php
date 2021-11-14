<?php

namespace App\Http\Livewire\Admin;

use App\Models\Seller;
use Livewire\Component;

class AllSellersComponent extends Component
{
    public function render()
    {
        $sellers = Seller::paginate(10);
        return view('livewire.admin.all-sellers-component', ['sellers'=>$sellers])->layout('layouts.base');
    }
}
