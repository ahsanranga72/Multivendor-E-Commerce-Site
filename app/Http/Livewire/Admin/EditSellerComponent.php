<?php

namespace App\Http\Livewire\Admin;

use App\Models\Seller;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class EditSellerComponent extends Component
{
    public $seller_id;
    public $username;
    public $shop_name;
    public $shop_slug;
    public $status;
    public $user_id;
    public $utype;

    public function mount($seller_id,)
    {
        $this->seller_id = $seller_id;
        $seller = Seller::where('id', $seller_id)->first();
        $this->username = $seller->username;
        $this->shop_name = $seller->shop_name;
        $this->shop_slug = $seller->shop_slug;
        $this->status = $seller->status;
        $this->user_id = $seller->user_id;
        $user = User::where('id', $seller->user_id)->first();
        $this->utype = $user->utype;
    }

    public function generateslug()
    {
        $this->shop_slug = Str::slug($this->username);
    }

    public function updateCategory()
     {

        $seller = Seller::find($this->seller_id);
        $seller->username = $this->username;
        $seller->shop_name = $this->shop_name;
        $seller->shop_slug = $this->shop_slug;
        $seller->user_id = $this->user_id;
        $seller->status = $this->status;
        $user = User::find($this->user_id);
        $user->utype = $this->utype;
        $user->save();
        $seller->save();
        session()->flash('message', 'Seller has been Update!');

        // return redirect()->route('admin.categories');
     }

    public function render()
    {
        return view('livewire.admin.edit-seller-component')->layout('layouts.base');
    }
}
