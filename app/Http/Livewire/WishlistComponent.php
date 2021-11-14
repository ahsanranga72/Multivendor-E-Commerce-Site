<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class WishlistComponent extends Component
{
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

    public function render()
    {
        return view('livewire.wishlist-component')->layout('layouts.base');
    }
}
