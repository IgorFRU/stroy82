<?php

namespace App\Notifications;

use App\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserOrderCreated extends Notification
{
    use Queueable;
    protected $order;
    protected $status;
    protected $user;

    protected $admin_phone;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $status, $user)
    {
        $this->order = $order;
        $this->status = $status;
        $this->user = $user;
        $this->admin_phone = Setting::first()->phone_main;
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
                    ->subject('Заказ в Stroy82.com офрмлен')
                    ->line('Уважаемый, ' . $this->user . '!')
                    ->line('Ваш заказ ' . $this->order .' был успешно создан.')
                    ->action('Открыть', url('/order/'. $this->order))
                    ->line('Статус заказа: '. $this->status . '.')
                    ->line('Благодарим за оказанное к нашей компании доверие! Если у вас возникнут вопросы или пожелания, можете связаться с нами но номеру телефона ' . $this->admin_phone . '.');
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
