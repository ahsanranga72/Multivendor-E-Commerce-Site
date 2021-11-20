<?php

namespace App\Http\Livewire\Seller;

use App\Models\Catagory;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class SellerEditProductComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $s_desc;
    public $desc;
    public $re_price;
    public $sa_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $newimage;
    public $product_id;
    public $category_id;
    public $seller_id;

    public function mount($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $this->name= $product->name;
        $this->slug= $product->slug;
        $this->s_desc= $product->s_desc;
        $this->desc= $product->desc;
        $this->re_price= $product->re_price;
        $this->sa_price= $product->sa_price;
        $this->SKU= $product->SKU;
        $this->stock_status= $product->stock_status;
        $this->featured= $product->featured;
        $this->quantity= $product->quantity;
        $this->image= $product->image;
        $this->product_id= $product->id;
        $this->category_id= $product->category_id;
    }

    public function generateslug()
    {
        $this->slug = Str::slug($this->name,'-');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => 'required',
            'slug' => 'required',
            's_desc' => 'required',
            'desc' => 'required',
            're_price' => 'required|numeric',
            'sa_price' => 'numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,png',
            'category_id' => 'required'
        ]);
    }

    public function updateproduct()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            's_desc' => 'required',
            'desc' => 'required',
            're_price' => 'required|numeric',
            'sa_price' => 'numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,png'
        ]);
        $product = Product::find($this->product_id);
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->s_desc = $this->s_desc;
        $product->desc = $this->desc;
        $product->re_price = $this->re_price;
        $product->sa_price = $this->sa_price;
        $product->SKU = $this->SKU;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        if($this->newimage)
        {
            $imageName = Carbon::now()->timestamp. '.' .$this->newimage->extension();
            $this->newimage->storeAs('products', $imageName);
            $product->image = $imageName;
        }
        $product->category_id = $this->category_id;
        $product->seller_id = auth()->user()->id;
        $product->save();
        session()->flash('message', 'Product has been updated successfullt!');
    }
    public function render()
    {
        $categories = Catagory::all();
        return view('livewire.seller.seller-edit-product-component', ['categories'=>$categories])->layout('layouts.base');
    }
}
