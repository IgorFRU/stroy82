<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCreated extends Notification
{
    use Queueable;
    protected $order;
    protected $summ;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $summ, $user)
    {
        $this->order = $order;
        $this->summ = $summ;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    // ->theme('')                    
                    ->subject('Новый заказ!')
                    ->line('Был создан новый заказ.')
                    ->action('Открыть', url('/admin/orders/'. $this->order))
                    ->line('На сумму '. $this->summ . 'рублей')
                    ->line('пользователь ' . url('/admin/consumers/'. $this->user));
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
