<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class SearchComponent extends Component
{
    public $sorting;
    public $pagesize;
    public $min_price;
    public $max_price;

    public $search;
    public $product_cat;
    public $product_cat_id;

    public function mount()
    {
        $this->sorting = "default";
        $this->pagesize = 12;


        $this->fill(request()->only('search', 'product_cat', 'product_cat_id'));
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
        if($this->sorting == 'date')
        {
            $products =Product::where('name', 'like', '%'.$this->search .'%')->where('category_id', 'like', '%'.$this->product_cat_id.'%')->orderby('created_at', 'DESC')->paginate($this->pagesize);
        }
        elseif($this->sorting=="price")
        {
            $products =Product::where('name', 'like', '%'.$this->search .'%')->where('category_id', 'like', '%'.$this->product_cat_id.'%')->orderby('re_price', 'ASC')->paginate($this->pagesize);
        }
        elseif($this->sorting=="price-desc")
        {
            $products =Product::where('name', 'like', '%'.$this->search .'%')->where('category_id', 'like', '%'.$this->product_cat_id.'%')->orderby('re_price', 'DESC')->paginate($this->pagesize);
        }
        else
        {
            $products =Product::where('name', 'like', '%'.$this->search .'%')->where('category_id', 'like', '%'.$this->product_cat_id.'%')->paginate($this->pagesize);
        }

        $catagories = Catagory::all();
        return view('livewire.search-component', ['products'=>$products, 'catagories'=>$catagories ])->layout("layouts.base");
    }
}
