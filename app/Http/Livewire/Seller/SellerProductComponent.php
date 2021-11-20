<?php

namespace App\Http\Livewire\Seller;

use App\Models\Product;
use App\Models\Seller;
use Livewire\Component;
use Livewire\WithPagination;

class SellerProductComponent extends Component
{
    public $seller;
    use WithPagination;
    public function deleteproduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product has been Deleted !');
    }
    public function render()
    {
        $seller = Seller::where('user_id', auth()->user()->id)->first();
        $products = Product::where(['seller_id'=>$seller->id])->paginate(10);
        return view('livewire.seller.seller-product-component', ['products'=>$products])->layout('layouts.base');
    }
}
