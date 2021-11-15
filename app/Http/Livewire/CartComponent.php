<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Carbon\Carbon;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Auth;


class CartComponent extends Component
{
    public $haveCouponCode;
    public $couponcode;
    public $discount;
    public $subtotalAfterDiscount;
    public $totalAfterDiscount;



    public function IncreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        $this->emitTo('cart-count-component', 'refreshComponent');
        Cart::instance('cart')->update($rowId, $qty);
    }

    public function DecreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        $this->emitTo('cart-count-component', 'refreshComponent');
        Cart::instance('cart')->update($rowId, $qty);
    }
    public function destroy($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item has been remove');

    }

    public function destroyAll()
    {
        Cart::instance('cart')->destroy();
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success_message', 'Items has been remove');
    }

    public function applyCouponCode()
    {
        $coupon = Coupon::where('code', $this->couponcode)->where('expiry_date','>=',Carbon::today())->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
        if(!$coupon)
        {
            session()->flash('coupon-massage', 'Coupon code is invalid');
            return;
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value
        ]);
    }

    public function calculatediscount()
    {
        if(session()->has('coupon'))
        {
            if(session()->get('coupon')['type'] == 'fixed')
            {
                $this->discount = session()->get('coupon')['value'];
            }
            else
            {
                $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
            }
            $this->subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
            $this->totalAfterDiscount = $this->subtotalAfterDiscount;

        }
    }

    public function removecoupon()
    {
        session()->forget('coupon');
    }

    public function checkout()
    {
        if(Auth::check())
        {
            return redirect()->route('checkout');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function setAmountForCheckout()
    {
        if(!Cart::instance('cart')->count() > 0)
        {
            session()->forget('checkout');
            return;
        }

        if(session()->has('coupon'))
        {
            session()->put('checkout',[
                'discount'=> $this->discount,
                'subtotal'=> $this->subtotalAfterDiscount,
                'total'=> $this->totalAfterDiscount
            ]);
        }
        else
        {
            session()->put('checkout',[
                'discount'=> 0,
                'subtotal'=> Cart::instance('cart')->subtotal(),
                'total'=> Cart::instance('cart')->total()

            ]);
        }
    }
    public function render()
    {
        if(session()->has('coupon'))
        {
            if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value'])
            {
                session()->forget('coupon');
            }
            else{
                $this->calculatediscount();
            }

        }
        $this->setAmountForCheckout();
        return view('livewire.cart-component')->layout("layouts.base");
    }
}
