<?php

namespace App\Jobs;

use App\Models\BulkOrder;
use App\Models\User;
use App\Notifications\BulkOrderUserNotification;
use App\Notifications\BulkOrderAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SendBulkOrderNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bulkOrder;

    /**
     * Create a new job instance.
     */
    public function __construct(BulkOrder $bulkOrder)
    {
        $this->bulkOrder = $bulkOrder;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load bulk order relationships for notifications
            $bulkOrder = $this->bulkOrder->load('user');

            Log::info('Bulk order notification processing started', [
                'bulk_order_id' => $this->bulkOrder->bulk_order_id,
                'user_id' => $this->bulkOrder->user_id,
                'institution' => $this->bulkOrder->institution
            ]);

            // Send notification to the user
            $user = $bulkOrder->user;
            if ($user) {
                $user->notify(new BulkOrderUserNotification($bulkOrder));
                Log::info('Bulk order notification: Sent to user', ['user_id' => $user->user_id]);
            } else {
                Log::error('Bulk order notification: User not found', ['user_id' => $this->bulkOrder->user_id]);
            }

            // Send notification to all admin users using Notification facade for batch sending
            $adminUsers = User::where('user_type', 'admin')->get();
            if ($adminUsers->isNotEmpty()) {
                Notification::send($adminUsers, new BulkOrderAdminNotification($bulkOrder));
                Log::info('Bulk order notification: Sent to ' . $adminUsers->count() . ' admin users');
            } else {
                Log::warning('Bulk order notification: No admin users found');
            }

            Log::info('Bulk order notification processing completed', [
                'bulk_order_id' => $this->bulkOrder->bulk_order_id
            ]);

        } catch (\Exception $e) {
            // Log notification errors but don't fail the job
            Log::error('Bulk order notification error', [
                'bulk_order_id' => $this->bulkOrder->bulk_order_id,
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
        Log::error('SendBulkOrderNotifications job failed', [
            'bulk_order_id' => $this->bulkOrder->bulk_order_id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
