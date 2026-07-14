<?php

namespace App\Jobs;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactQueryNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contactQuery;

    /**
     * Create a new job instance.
     */
    public function __construct(ContactQuery $contactQuery)
    {
        $this->contactQuery = $contactQuery;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load contact query relationships for notifications
            $contactQuery = $this->contactQuery->load('user');

            Log::info('Contact query notification processing started', [
                'contact_query_id' => $this->contactQuery->id,
                'email' => $this->contactQuery->email,
                'subject' => $this->contactQuery->subject
            ]);

            // Get admin email from environment variable
            $adminEmails = env('ADMIN_EMAILS', 'admin@example.com');
            
            // Convert comma-separated emails to array and trim whitespace
            $adminEmailArray = array_map('trim', explode(',', $adminEmails));
            
            // Send directly to the email addresses in ADMIN_EMAILS env variable
            foreach ($adminEmailArray as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    try {
                        Mail::send('emails.contact-query-admin', ['contactQuery' => $contactQuery], function ($message) use ($email, $contactQuery) {
                            $message->to($email)
                                    ->subject('New Contact Form Submission: ' . $contactQuery->subject . ' - FM Uniforms');
                        });
                        Log::info('Contact query notification: Sent to admin email', ['email' => $email]);
                    } catch (\Exception $e) {
                        Log::error('Failed to send contact query notification to admin email', [
                            'email' => $email,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }

            Log::info('Contact query notification processing completed', [
                'contact_query_id' => $this->contactQuery->id
            ]);

        } catch (\Exception $e) {
            // Log notification errors but don't fail the job
            Log::error('Contact query notification error', [
                'contact_query_id' => $this->contactQuery->id,
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
        Log::error('SendContactQueryNotification job failed', [
            'contact_query_id' => $this->contactQuery->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
