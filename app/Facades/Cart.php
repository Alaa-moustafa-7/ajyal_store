<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;
use App\Repository\Cart\CartRepository;

class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CartRepository::class;
    }
}