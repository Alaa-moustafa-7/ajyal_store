<?php

namespace App\View\Components;

use App\Facades\Cart;
use Illuminate\View\Component;
use App\Repository\Cart\CartRepository;

class CartMenu extends Component
{
    public $items;

    public $total;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CartRepository $cart)
    {
        $this->items = $cart->get();
        $this->total = $cart->total();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
