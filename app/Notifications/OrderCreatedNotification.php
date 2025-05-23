<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Listeners\SendOrderCreatedNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;


class OrderCreatedNotification extends Notification
{
    use Queueable;

    private $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];

        // $channels = ['database'];

        // if ($notifiable->notification_preferences['order_created']['sms']){
        //     $channels[] = 'vonage';
        // }
        // if ($notifiable->notification_preferences['order_created']['mail']){
        //     $channels[] = 'mail';
        // }
        // if ($notifiable->notification_preferences['order_created']['broadcast']){
        //     $channels[] = 'broadcast';
        // }

        // return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $addr = $this->order->billingAddress;
        return (new MailMessage)
                    ->subject("New Order #{$this->order->number}")
                    ->from('notification@ajyal-store.ps', 'AJYAL Store')
                    ->greeting("Hi {$notifiable->name}")
                    ->line("A new order (#{$this->order->number}) created by {$addr->name} From {$addr->country_name}.")
                    ->action('View order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;
        return [
            'body' => "A new order (#{$this->order->number}) created by {$addr->name} From {$addr->country_name}.",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $addr = $this->order->billingAddress;
        return new BroadcastMessage([
            'body' => "A new order (#{$this->order->number}) created by {$addr->name} From {$addr->country_name}.",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
