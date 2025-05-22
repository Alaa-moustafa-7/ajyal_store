<?php

namespace App\Repository\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{
    protected $item;

    public function __construct()
    {
        $this->item = collect([]);
    }

    public function get(): Collection
    {
        if (!$this->item->count()){
            $this->item = Cart::with('product')->get();
        }
        return $this->item;
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)
            ->first();

        if (!$item){
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $this->get()->push($cart);
            return $cart;
        }
        $item->increment('quantity', $quantity);
        return $item;
    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
    }

    public function total()
    {
        /*return Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');*/

        return $this->get()->sum(function($item){
            return $item->quantity * $item->product->price;
        });
    }

}