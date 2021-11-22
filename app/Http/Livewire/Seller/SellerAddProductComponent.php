<?php

namespace App\Http\Livewire\Seller;

use App\Models\Catagory;
use App\Models\Product;
use App\Models\Seller;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class SellerAddProductComponent extends Component
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
    public $category_id;
    public $seller_id;
    public $seller;
    public function mount()
    {
        $this->stock_status = 'instock';
        $this->featured = 0;
    }

    public function generateslug()
    {
        $this->slug = Str::slug($this->name,'-');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name' => 'required',
            'slug' => 'required|unique:products',
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

    public function addproduct()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:products',
            's_desc' => 'required',
            'desc' => 'required',
            're_price' => 'required|numeric',
            'sa_price' => 'numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,png'
        ]);
        $product = new Product();
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
        $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
        $this->image->storeAs('products', $imageName);
        $product->image = $imageName;
        $product->category_id = $this->category_id;
        $seller = Seller::where('user_id', auth()->user()->id)->first();
        $product->seller_id = $seller->id;
        $product->save();
        session()->flash('message', 'Product has been created successfullt!');
    }

    public function render()
    {
        $categories = Catagory::all();
        return view('livewire.seller.seller-add-product-component', ['categories'=>$categories])->layout('layouts.base');
    }
}
