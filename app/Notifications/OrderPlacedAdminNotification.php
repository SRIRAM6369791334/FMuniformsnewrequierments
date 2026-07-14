<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedAdminNotification extends Notification
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
        $user = $order->user;

        // Extract customer information
        $customerInfo = $this->extractCustomerInfo($order, $user);

        // Format payment status
        $paymentStatusText = 'Pending';
        if ($order->payment_status == 1) {
            $paymentStatusText = $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Paid';
        }

        // Format delivery status
        $deliveryStatusText = 'Pending';
        switch ($order->delivery_status) {
            case 0: $deliveryStatusText = 'Order Placed'; break;
            case 1: $deliveryStatusText = 'Processing'; break;
            case 2: $deliveryStatusText = 'Shipped'; break;
            case 3: $deliveryStatusText = 'Delivered'; break;
            case 4: $deliveryStatusText = 'Cancelled'; break;
        }

        return (new MailMessage)
            ->subject('New Order Received - ' . $order->order_id . ' - FM Uniforms')
            ->view('emails.order-placed-admin', [
                'order' => $order,
                'orderSlots' => $orderSlots,
                'customerInfo' => $customerInfo,
                'paymentStatusText' => $paymentStatusText,
                'deliveryStatusText' => $deliveryStatusText
            ]);
    }

    /**
     * Extract customer information from order
     */
    private function extractCustomerInfo($order, $user)
    {
        $customerInfo = [
            'name' => 'Guest Customer',
            'email' => 'Not provided',
            'phone' => 'Not provided'
        ];

        if ($user) {
            $customerInfo['name'] = $user->F_name . ' ' . $user->L_name;
            $customerInfo['email'] = $user->email;
            $customerInfo['phone'] = $user->phone ?? 'Not provided';
        } elseif ($order->guest_email) {
            $customerInfo['name'] = $order->guest_name ?? 'Guest Customer';
            $customerInfo['email'] = $order->guest_email;
            $customerInfo['phone'] = $order->guest_phone ?? 'Not provided';
        }

        return $customerInfo;
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
