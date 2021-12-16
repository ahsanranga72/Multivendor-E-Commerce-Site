<?php

namespace App\Http\Livewire;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterShopComponent extends Component
{
    public $username;
    public $shop_name;
    public $shop_slug;
    public $user_id;
    public $utype;

    public function generateslug()
    {
        $this->shop_slug = Str::slug($this->username);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'username' => 'required',
            'shop_name' => 'required',
            'shop_slug' => 'required|unique:sellers'
        ]);
    }

    public function storeshop()
    {
        $this->validate([
            'username' => 'required',
            'shop_name' => 'required',
            'shop_slug' => 'required|unique:sellers'
        ]);
        $shop = new Seller();
        $shop->username = $this->username;
        $shop->shop_name = $this->shop_name;
        $shop->shop_slug = $this->shop_slug;
        $shop->user_id = Auth::user()->id;
        $shop->save(); 

        session()->flash('message', 'Shop has been created successfully');
    }

    public function render()
    {
        return view('livewire.register-shop-component')->layout('layouts.base');
    }
}
