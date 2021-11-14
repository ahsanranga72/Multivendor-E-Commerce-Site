<?php

namespace App\Http\Livewire;

use App\Models\Catagory;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;

class HomeComponent extends Component
{

    public function render()
    {
        $sliders = HomeSlider::where('status', 1)->get();
        $lproducts = Product::orderBy('created_at', 'DESC')->get()->take(10);
        $category = HomeCategory::find(1);
        $cats = explode(',',$category->sel_categories);
        $categories = Catagory::whereIn('id', $cats)->get();
        $no_of_products = $category->no_of_products;
        $sproducts = Product::where('sa_price','>',0)->inRandomOrder()->get()->take(10);
        $sale =Sale::find(1);
        return view('livewire.home-component',['sliders'=>$sliders, 'lproducts'=>$lproducts,'categories'=>$categories, 'no_of_products'=>$no_of_products, 'sproducts'=>$sproducts, 'sale'=>$sale,])->layout("layouts.base");
    }
}
