<?php

namespace App\Listeners;

use App\Notifications\OrderCreatedNotification;
use App\Models\User;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->order;

        $user = User::where('store_id', $order->store_id)->first();
        if ($user){
            $user->notify(new OrderCreatedNotification($order));
        }
        
    }
}
