<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'user_id', 'payment_method', 'status', 'payment_status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest customer',
        ]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name', 'price', 'quantity', 'options',
            ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');
    }

     public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'shipping');
    }

    public static function booted()
    {
        static::creating(function(Order $order){
            // 20220001 , 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number){
            return $number + 1;
        }
        return $year . '0001';
    }
}
