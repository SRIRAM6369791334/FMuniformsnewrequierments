<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

/**
 * Guest User class for sending notifications to guest emails
 * This is a standalone class to allow proper serialization in queued notifications
 */
class GuestUser
{
    use Notifiable;

    public $email;
    public $name = 'Valued Customer';

    public function __construct($email, $name = null)
    {
        $this->email = $email;
        if ($name) {
            $this->name = $name;
        }
    }

    public function routeNotificationForMail($notification = null)
    {
        return $this->email;
    }

    public function getKey()
    {
        return $this->email;
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getAuthIdentifier()
    {
        return $this->email;
    }
}
