<?php

namespace App\Http\Livewire\Seller;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class SellerProductComponent extends Component
{
    use WithPagination;
    public function deleteproduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product has been Deleted !');
    }
    public function render()
    {
        $products = Product::where(['seller_id'=>auth()->user()->id])->paginate(10);
        return view('livewire.seller.seller-product-component', ['products'=>$products])->layout('layouts.base');
    }
}
