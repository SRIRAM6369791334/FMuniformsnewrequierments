<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedGuestWelcomeNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->load('orderSlots.product');
        $orderSlots = $order->orderSlots;

        // Format payment status
        $paymentStatusText = 'Pending';
        if ($order->payment_status == 1) {
            $paymentStatusText = $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Paid';
        }

        return (new MailMessage)
            ->subject('Welcome to FM Uniforms - Order Confirmation')
            ->view('emails.order-placed-guest-welcome', [
                'order' => $order,
                'orderSlots' => $orderSlots,
                'paymentStatusText' => $paymentStatusText,
                'notifiable' => $notifiable
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
