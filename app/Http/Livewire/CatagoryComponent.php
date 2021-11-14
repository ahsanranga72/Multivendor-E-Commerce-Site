<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class CatagoryComponent extends Component
{
    public $sorting;
    public $pagesize;
    public $catagory_slug;

    public function mount($catagory_slug)
    {
        $this->sorting = "default";
        $this->pagesize = 12;
        $this->catagory_slug = $catagory_slug;
    }
    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added in cart');
        return redirect()->route('product.cart');
    }
    use WithPagination;
    public function render()
    {
        $catagory = Catagory::where('slug', $this->catagory_slug)->first();
        $catagory_id = $catagory->id;
        $catagory_name = $catagory->name;
        if($this->sorting == 'date')
        {
            $products =Product::where('category_id',$catagory_id)->orderby('created_at', 'DESC')->paginate($this->pagesize);
        }
        elseif($this->sorting=="price")
        {
            $products =Product::where('category_id',$catagory_id)->orderby('re_price', 'ASC')->paginate($this->pagesize);
        }
        elseif($this->sorting=="price-desc")
        {
            $products =Product::where('category_id',$catagory_id)->orderby('re_price', 'DESC')->paginate($this->pagesize);
        }
        else
        {
            $products =Product::where('category_id',$catagory_id)->paginate($this->pagesize);
        }

        $catagories = Catagory::all();
        return view('livewire.catagory-component', ['products'=>$products, 'catagories'=>$catagories, 'catagory_name'=>$catagory_name])->layout("layouts.base");
    }
}
