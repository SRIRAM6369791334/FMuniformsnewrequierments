<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    private $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );
    }

    /**
     * Create Razorpay order
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'amount' => 'required|numeric|min:1'
        ]);

        try {
            $orderData = [
                'receipt' => $request->order_id,
                'amount' => $request->amount * 100, // Amount in paisa
                'currency' => 'INR',
                'payment_capture' => 1
            ];

            $razorpayOrder = $this->razorpay->order->create($orderData);

            // Update order with Razorpay order ID
            Order::where('order_id', $request->order_id)
                ->update(['razorpay_order_id' => $razorpayOrder->id]);

            Log::info('Razorpay order created', [
                'order_id' => $request->order_id,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $request->amount
            ]);

            return response()->json($razorpayOrder);
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed', [
                'order_id' => $request->order_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to create payment order'], 500);
        }
    }

    /**
     * Verify payment signature
     */
    public function verifyPayment(Request $request)
    {
        Log::info('Payment verification started', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string'
        ]);

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            Log::info('Verifying payment signature', [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id
            ]);

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            Log::info('Payment signature verified successfully', [
                'razorpay_order_id' => $request->razorpay_order_id
            ]);

            // Update order status - this will be visible in admin panel
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if ($order) {
                Log::info('Order found for payment verification', [
                    'order_id' => $order->order_id,
                    'current_payment_status' => $order->payment_status,
                    'current_razorpay_payment_id' => $order->razorpay_payment_id
                ]);

                $updateData = [
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'payment_status' => 1 // Use integer: 1 for paid
                ];

                $updated = $order->update($updateData);

                Log::info('Order updated after payment verification', [
                    'order_id' => $order->order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'update_successful' => $updated,
                    'new_payment_status' => $order->fresh()->payment_status
                ]);

                if (!$updated) {
                    Log::error('Failed to update order after payment verification', [
                        'order_id' => $order->order_id,
                        'update_data' => $updateData
                    ]);
                    return response()->json(['status' => 'failed', 'message' => 'Failed to update order status'], 500);
                }
            } else {
                Log::error('Order not found for payment verification', [
                    'razorpay_order_id' => $request->razorpay_order_id
                ]);
                return response()->json(['status' => 'failed', 'message' => 'Order not found'], 404);
            }

            Log::info('Payment verification completed successfully', [
                'order_id' => $order->order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Handle Razorpay webhooks
     */
    public function handleWebhook(Request $request)
    {
        try {
            $webhookSecret = config('services.razorpay.webhook_secret');
            $signature = $request->header('X-Razorpay-Signature');

            // Verify webhook signature
            $expectedSignature = hash_hmac('sha256', $request->getContent(), $webhookSecret);

            if (!hash_equals($expectedSignature, $signature)) {
                Log::warning('Invalid webhook signature');
                return response()->json(['status' => 'invalid_signature'], 400);
            }

            $event = $request->event;
            $paymentEntity = $request->payment_entity;

            Log::info('Razorpay webhook received', [
                'event' => $event,
                'payment_id' => $paymentEntity['id'] ?? null
            ]);

            switch ($event) {
                case 'payment.captured':
                    // Payment was successfully captured - use integer 1 for paid
                    $updated = Order::where('razorpay_payment_id', $paymentEntity['id'])
                        ->update(['payment_status' => 1]);

                    Log::info('Webhook: Payment captured', [
                        'razorpay_payment_id' => $paymentEntity['id'],
                        'updated_rows' => $updated
                    ]);
                    break;

                case 'payment.failed':
                    // Payment failed - use integer 2 for failed
                    $updated = Order::where('razorpay_payment_id', $paymentEntity['id'])
                        ->update(['payment_status' => 2]);

                    Log::info('Webhook: Payment failed', [
                        'razorpay_payment_id' => $paymentEntity['id'],
                        'updated_rows' => $updated
                    ]);
                    break;

                case 'payment.authorized':
                    // Payment was authorized - try to save payment_id if not already saved
                    $order = Order::where('razorpay_order_id', $paymentEntity['order_id'] ?? null)->first();

                    if ($order && !$order->razorpay_payment_id) {
                        $order->update([
                            'razorpay_payment_id' => $paymentEntity['id'],
                            'payment_status' => 0 // Authorized but not captured yet
                        ]);

                        Log::info('Webhook: Payment authorized - saved payment_id', [
                            'order_id' => $order->order_id,
                            'razorpay_payment_id' => $paymentEntity['id']
                        ]);
                    } else {
                        Log::info('Webhook: Payment authorized - payment_id already exists or order not found', [
                            'razorpay_payment_id' => $paymentEntity['id'],
                            'order_found' => $order ? true : false,
                            'payment_id_exists' => $order ? ($order->razorpay_payment_id ? true : false) : null
                        ]);
                    }
                    break;
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return response()->json(['status' => 'error'], 500);
        }
    }
}
