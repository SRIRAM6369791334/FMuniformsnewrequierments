<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedUserNotification extends Notification
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
        $order = $this->order->load('orderSlots.product', 'user');
        $orderSlots = $order->orderSlots;

        // Handle both User models and generic email addresses
        $customerName = $notifiable->name ?? 'Valued Customer';
        $isGuestUser = !($notifiable instanceof \App\Models\User);

        // Format payment status
        $paymentStatusText = 'Pending';
        if ($order->payment_status == 1) {
            $paymentStatusText = $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Paid';
        }

        return (new MailMessage)
            ->subject('Order Confirmation - ' . $order->order_id . ' - FM Uniforms')
            ->view('emails.order-placed-user', [
                'order' => $order,
                'orderSlots' => $orderSlots,
                'customerName' => $customerName,
                'isGuestUser' => $isGuestUser,
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
