<?php

namespace App\Notifications;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactQueryAdminNotification extends Notification
{
    use Queueable;

    public $contactQuery;

    /**
     * Create a new notification instance.
     */
    public function __construct(ContactQuery $contactQuery)
    {
        $this->contactQuery = $contactQuery;
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
        $contactQuery = $this->contactQuery->load('user');

        return (new MailMessage)
            ->subject('New Contact Form Submission: ' . $contactQuery->subject . ' - FM Uniforms')
            ->view('emails.contact-query-admin', [
                'contactQuery' => $contactQuery
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
