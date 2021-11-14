<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class ShopComponent extends Component
{
    public $sorting;
    public $pagesize;
    public $min_price;
    public $max_price;



    public function mount()
    {
        $this->sorting = "default";
        $this->pagesize = 12;

        $this->min_price = 1;
        $this->max_price = 1000;
    }
    public function store($product_id, $product_name, $product_price)
    {
        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item added in cart');
        // return redirect()->route('product.cart');
    }
    public function addtowishlist($product_id, $product_name, $product_price)
    {
        Cart::instance('whishlist')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item added in Whishlist');
    }

    public function removefromwishlist($product_id)
    {
        foreach(Cart::instance('whishlist')->content() as $witem)
        {
            if($witem->id = $product_id)
            {
                Cart::instance('whishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-count-component', 'refreshComponent');
                return;
            }
        }
    }

    use WithPagination;

    public function render()
    {

        if($this->sorting == 'date')
        {
            $products =Product::whereBetween('re_price',[$this->min_price,$this->max_price])->orderby('created_at', 'DESC')->paginate($this->pagesize);
        }
        elseif($this->sorting=="price")
        {
            $products =Product::whereBetween('re_price',[$this->min_price,$this->max_price])->orderby('re_price', 'ASC')->paginate($this->pagesize);
        }
        elseif($this->sorting=="price-desc")
        {
            $products =Product::whereBetween('re_price',[$this->min_price,$this->max_price])->orderby('re_price', 'DESC')->paginate($this->pagesize);
        }
        else
        {
            $products =Product::whereBetween('re_price',[$this->min_price,$this->max_price])->paginate($this->pagesize);
        }

        $catagories = Catagory::all();
        return view('livewire.shop-component', ['products'=>$products, 'catagories'=>$catagories ])->layout("layouts.base");
    }
}
