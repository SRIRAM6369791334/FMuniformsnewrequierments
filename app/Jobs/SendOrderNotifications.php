<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPlacedUserNotification;
use App\Notifications\OrderPlacedAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SendOrderNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $userId;
    protected $isGuest;
    protected $forceGuestCheckout;
    protected $checkoutEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order, $userId, $isGuest, $forceGuestCheckout, $checkoutEmail)
    {
        $this->order = $order;
        $this->userId = $userId;
        $this->isGuest = $isGuest;
        $this->forceGuestCheckout = $forceGuestCheckout;
        $this->checkoutEmail = $checkoutEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load order relationships for notifications
            $order = $this->order->load('user');

            Log::info('Background notification processing started', [
                'order_id' => $this->order->order_id,
                'userId' => $this->userId,
                'isGuest' => $this->isGuest,
                'force_guest_checkout' => $this->forceGuestCheckout,
                'email' => $this->checkoutEmail
            ]);

            // Send notification to the customer
            if ($this->userId || isset($user)) {
                // Logged-in user or guest who created account
                Log::info('Background notification: Sending to user account');
                // Optimized: Use already loaded user if available, otherwise fetch
                $customer = $this->userId ? ($user ?? User::find($this->userId)) : $user;
                if ($customer) {
                    if ($this->isGuest) {
                        // Send welcome notification for new guest-turned-user
                        Log::info('Background notification: Guest welcome notification');
                        $customer->notify(new \App\Notifications\OrderPlacedGuestWelcomeNotification($order));
                    } else {
                        // Send regular order notification for existing users
                        Log::info('Background notification: Regular user notification');
                        $customer->notify(new OrderPlacedUserNotification($order));
                    }
                } else {
                    Log::error('Background notification: Customer not found', ['userId' => $this->userId]);
                }
            } elseif ($this->isGuest) {
                // Pure guest checkout (no account created) - send to checkout email
                Log::info('Background notification: Sending to guest email', ['email' => $this->checkoutEmail]);
                $guestUser = new \App\Models\GuestUser($this->checkoutEmail, 'Valued Customer');
                $guestUser->notify(new OrderPlacedUserNotification($order));
            } else {
                Log::warning('Background notification: No notification path taken', [
                    'userId' => $this->userId,
                    'isGuest' => $this->isGuest,
                    'email' => $this->checkoutEmail,
                ]);
            }

            // Send notification to admin emails directly
            // Check for specific admin emails from environment or config
            $adminEmailAddresses = explode(',', env('ADMIN_EMAILS', 'admin@fmuniforms.com'));
            $adminEmailAddresses = array_map('trim', $adminEmailAddresses);

            // Send admin notifications directly to email addresses
            if (!empty($adminEmailAddresses)) {
                try {
                    // Create GuestUser instances for each admin email
                    $adminNotifiables = [];
                    foreach ($adminEmailAddresses as $email) {
                        $adminNotifiables[] = new \App\Models\GuestUser($email, 'FM Uniforms Admin');
                    }

                    Notification::send($adminNotifiables, new OrderPlacedAdminNotification($order));
                    \Log::info('Admin notifications sent to email addresses', [
                        'admin_emails' => $adminEmailAddresses,
                        'order_id' => $this->order->order_id
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to send admin notifications', [
                        'order_id' => $this->order->order_id,
                        'error' => $e->getMessage(),
                        'admin_emails' => $adminEmailAddresses
                    ]);
                }
            } else {
                \Log::error('No admin email addresses configured. Please add ADMIN_EMAILS to .env file', [
                    'order_id' => $this->order->order_id
                ]);
            }

            Log::info('Background notification processing completed', [
                'order_id' => $this->order->order_id
            ]);

        } catch (\Exception $e) {
            // Log notification errors but don't fail the job
            Log::error('Background notification error', [
                'order_id' => $this->order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendOrderNotifications job failed', [
            'order_id' => $this->order->order_id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
