<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class FixMissingPaymentIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:fix-missing-ids {--order-id= : Specific order ID to fix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix orders that have razorpay_order_id but missing razorpay_payment_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $specificOrderId = $this->option('order-id');

        if ($specificOrderId) {
            $this->fixSpecificOrder($specificOrderId);
            return;
        }

        $this->fixAllMissingPaymentIds();
    }

    private function fixSpecificOrder($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            $this->error("Order {$orderId} not found");
            return;
        }

        if (!$order->razorpay_order_id) {
            $this->error("Order {$orderId} doesn't have a razorpay_order_id");
            return;
        }

        if ($order->razorpay_payment_id) {
            $this->info("Order {$orderId} already has razorpay_payment_id: {$order->razorpay_payment_id}");
            return;
        }

        $this->info("Checking Razorpay API for order: {$order->razorpay_order_id}");

        try {
            $razorpay = new Api(
                config('services.razorpay.key_id'),
                config('services.razorpay.key_secret')
            );

            $razorpayOrder = $razorpay->order->fetch($order->razorpay_order_id);

            if (isset($razorpayOrder->payments) && !empty($razorpayOrder->payments)) {
                $payment = $razorpayOrder->payments[0]; // Get first payment

                if ($payment->status === 'captured' || $payment->status === 'authorized') {
                    $order->update([
                        'razorpay_payment_id' => $payment->id,
                        'payment_status' => ($payment->status === 'captured') ? 1 : 0
                    ]);

                    $this->info("Fixed order {$orderId}:");
                    $this->info("  - razorpay_payment_id: {$payment->id}");
                    $this->info("  - payment_status: " . (($payment->status === 'captured') ? 'paid' : 'authorized'));

                    Log::info('Fixed missing payment_id via command', [
                        'order_id' => $orderId,
                        'razorpay_payment_id' => $payment->id,
                        'payment_status' => $payment->status
                    ]);
                } else {
                    $this->warn("Payment status is {$payment->status} for order {$orderId}");
                }
            } else {
                $this->warn("No payments found for Razorpay order {$order->razorpay_order_id}");
            }
        } catch (\Exception $e) {
            $this->error("Error checking Razorpay API: " . $e->getMessage());
            Log::error('Error in fix command', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function fixAllMissingPaymentIds()
    {
        $orders = Order::whereNotNull('razorpay_order_id')
            ->whereNull('razorpay_payment_id')
            ->where('payment_method', 'razorpay')
            ->get();

        $this->info("Found {$orders->count()} orders with missing razorpay_payment_id");

        if ($orders->isEmpty()) {
            $this->info("No orders need fixing.");
            return;
        }

        $bar = $this->output->createProgressBar($orders->count());
        $bar->start();

        $fixed = 0;
        $errors = 0;

        foreach ($orders as $order) {
            try {
                $razorpay = new Api(
                    config('services.razorpay.key_id'),
                    config('services.razorpay.key_secret')
                );

                $razorpayOrder = $razorpay->order->fetch($order->razorpay_order_id);

                if (isset($razorpayOrder->payments) && !empty($razorpayOrder->payments)) {
                    $payment = $razorpayOrder->payments[0];

                    if ($payment->status === 'captured' || $payment->status === 'authorized') {
                        $order->update([
                            'razorpay_payment_id' => $payment->id,
                            'payment_status' => ($payment->status === 'captured') ? 1 : 0
                        ]);

                        $fixed++;

                        Log::info('Fixed missing payment_id via bulk command', [
                            'order_id' => $order->order_id,
                            'razorpay_payment_id' => $payment->id,
                            'payment_status' => $payment->status
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $errors++;
                Log::error('Error fixing order in bulk command', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage()
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Fixed: {$fixed} orders");
        $this->info("Errors: {$errors} orders");
    }
}
