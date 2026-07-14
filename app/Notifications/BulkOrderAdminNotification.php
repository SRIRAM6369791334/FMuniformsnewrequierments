<?php

namespace App\Notifications;

use App\Models\BulkOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BulkOrderAdminNotification extends Notification
{
    use Queueable;

    public $bulkOrder;

    /**
     * Create a new notification instance.
     */
    public function __construct(BulkOrder $bulkOrder)
    {
        $this->bulkOrder = $bulkOrder;
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
        $bulkOrder = $this->bulkOrder->load('user');

        return (new MailMessage)
            ->subject('New Bulk Order Request - ' . $bulkOrder->institution . ' - FM Uniforms')
            ->view('emails.bulk-order-admin', [
                'bulkOrder' => $bulkOrder
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
