<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Order;
use App\Models\BulkOrder;
use App\Notifications\OrderPlacedUserNotification;
use App\Notifications\OrderPlacedAdminNotification;
use App\Notifications\OrderPlacedGuestWelcomeNotification;
use App\Notifications\BulkOrderUserNotification;
use App\Notifications\BulkOrderAdminNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendTestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--admin-email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test emails to verify email notification designs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $testEmail = $this->argument('email');
        $adminEmail = $this->option('admin-email') ?? $testEmail;

        $this->info("Sending test emails to: {$testEmail}");
        $this->info("Sending admin emails to: {$adminEmail}");
        $this->newLine();

        // Create a test user object
        $testUser = new \stdClass();
        $testUser->name = 'Test User';
        $testUser->email = $testEmail;

        // Create a test admin object
        $testAdmin = new \stdClass();
        $testAdmin->name = 'Admin';
        $testAdmin->email = $adminEmail;

        try {
            // 1. Send OrderPlacedUserNotification
            $this->info('1. Sending OrderPlacedUserNotification...');
            $order = $this->createTestOrder();
            Notification::route('mail', $testEmail)
                ->notify(new OrderPlacedUserNotification($order));
            $this->info('✓ Order confirmation email sent to user');
            $this->newLine();

            // 2. Send OrderPlacedAdminNotification
            $this->info('2. Sending OrderPlacedAdminNotification...');
            Notification::route('mail', $adminEmail)
                ->notify(new OrderPlacedAdminNotification($order));
            $this->info('✓ Order notification email sent to admin');
            $this->newLine();

            // 3. Send OrderPlacedGuestWelcomeNotification
            $this->info('3. Sending OrderPlacedGuestWelcomeNotification...');
            Notification::route('mail', $testEmail)
                ->notify(new OrderPlacedGuestWelcomeNotification($order));
            $this->info('✓ Guest welcome email sent');
            $this->newLine();

            // 4. Send BulkOrderUserNotification
            $this->info('4. Sending BulkOrderUserNotification...');
            $bulkOrder = $this->createTestBulkOrder();
            Notification::route('mail', $testEmail)
                ->notify(new BulkOrderUserNotification($bulkOrder));
            $this->info('✓ Bulk order confirmation email sent to user');
            $this->newLine();

            // 5. Send BulkOrderAdminNotification
            $this->info('5. Sending BulkOrderAdminNotification...');
            Notification::route('mail', $adminEmail)
                ->notify(new BulkOrderAdminNotification($bulkOrder));
            $this->info('✓ Bulk order notification email sent to admin');
            $this->newLine();

            // 6. Send ResetPasswordNotification
            $this->info('6. Sending ResetPasswordNotification...');
            $testOtp = '123456';
            Notification::route('mail', $testEmail)
                ->notify(new ResetPasswordNotification($testOtp));
            $this->info('✓ Password reset OTP email sent');
            $this->newLine();

            $this->newLine();
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('✅ All 6 test emails have been sent successfully!');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();
            $this->info("📧 User emails sent to: {$testEmail}");
            $this->info("👨‍💼 Admin emails sent to: {$adminEmail}");
            $this->newLine();
            $this->info('Please check your inbox for the test emails.');
            $this->warn('Note: Check spam folder if emails are not in inbox.');

        } catch (\Exception $e) {
            $this->error('Error sending emails: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }

        return 0;
    }

    /**
     * Create a test order with sample data
     */
    private function createTestOrder()
    {
        $order = new \stdClass();
        $order->order_id = 'ORD-TEST-' . rand(1000, 9999);
        $order->date_ordered_on = now();
        $order->grand_total_amount = 2499.00;
        $order->payment_status = 1;
        $order->payment_method = 'cod';
        $order->delivery_status = 0;
        $order->order_name = '123 Test Street, Test City, State, 123456';
        $order->order_notes = 'Please deliver between 9 AM - 5 PM';
        $order->user = null; // Guest order

        // Create test order slots (items)
        $slot1 = new \stdClass();
        $slot1->product_name = 'School Uniform Shirt';  
        $slot1->size_value = 'M';
        $slot1->color_value = 'White';
        $slot1->quantity = 2;
        $slot1->product_rate = 599.00;
        $slot1->product_total = 1198.00;
        $slot1->product = null;

        $slot2 = new \stdClass();
        $slot2->product_name = 'School Uniform Pants';
        $slot2->size_value = 'L';
        $slot2->color_value = 'Navy Blue';
        $slot2->quantity = 2;
        $slot2->product_rate = 650.50;
        $slot2->product_total = 1301.00;
        $slot2->product = null;

        $order->orderSlots = collect([$slot1, $slot2]);

        return $order;
    }

    /**
     * Create a test bulk order with sample data
     */
    private function createTestBulkOrder()
    {
        $bulkOrder = new \stdClass();
        $bulkOrder->bulk_order_id = 'BULK-' . rand(1000, 9999);
        $bulkOrder->institution = 'ABC International School';
        $bulkOrder->uniform_type = 'School Uniforms - Complete Set';
        $bulkOrder->quantity = 150;
        $bulkOrder->budget = '₹75,000 - ₹1,00,000';
        $bulkOrder->first_name = 'Rajesh';
        $bulkOrder->last_name = 'Kumar';
        $bulkOrder->email = 'rajesh.kumar@abcschool.edu';
        $bulkOrder->phone = '+91-98765-43210';
        $bulkOrder->message = "We need complete uniform sets including:\n- Shirts (3 per student)\n- Pants (2 per student)\n- Ties\n- Belts\n- School badges\n\nPreferred delivery: Before March 2026\nPayment terms: 50% advance, 50% on delivery";
        $bulkOrder->created_at = now();
        $bulkOrder->user = null;

        return $bulkOrder;
    }
}
