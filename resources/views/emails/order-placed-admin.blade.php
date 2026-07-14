<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f8f9fa;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; max-width: 600px;">
                    <!-- Header -->
                    <tr>
                        <td style="text-align: center; padding: 20px 0;">
                            <img src="{{ url('/media/images/logo.png') }}" alt="FM Uniforms" style="max-width: 180px; height: auto;">
                            <div style="margin: 20px 0; border-bottom: 1px solid #e5e7eb;"></div>
                        </td>
                    </tr>
                    
                    <!-- Title -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h2 style="text-align: center; color: #00274D; margin: 20px 0;">New Order Received</h2>
                            <p style="text-align: center; font-size: 14px; color: #666666; margin: 10px 0 30px 0;">
                                A new order has been placed on FM Uniforms. Please process this order as soon as possible.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Order Information -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Order Information</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; width: 40%;">Order Number</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $order->order_id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Order Date</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $order->date_ordered_on->format('F j, Y') }}</td>
                                </tr>
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Total Amount</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; color: #e11e12;">₹{{ number_format($order->grand_total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Payment Status</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $paymentStatusText }}</td>
                                </tr>
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Payment Method</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Delivery Status</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $deliveryStatusText }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Customer Information -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Customer Information</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; width: 40%;">Customer Name</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $customerInfo['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Email</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $customerInfo['email'] }}</td>
                                </tr>
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Phone</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $customerInfo['phone'] }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Items Ordered -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Items Ordered</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <thead>
                                    <tr style="background-color: #00274D; color: #ffffff;">
                                        <th style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: left;">Product</th>
                                        <th style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: center;">Qty</th>
                                        <th style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: right;">Unit Price</th>
                                        <th style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($orderSlots->count() > 0)
                                        @foreach($orderSlots as $index => $slot)
                                            <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#fafafa' }};">
                                                <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">
                                                    <div style="font-weight: 600; color: #333333; margin-bottom: 5px;">{{ $slot->product_name ?? ($slot->product ? $slot->product->product_name : 'Product') }}</div>
                                                    @if($slot->size_value || $slot->color_value)
                                                        <table cellpadding="0" cellspacing="0" style="font-size: 12px; color: #666666;">
                                                            <tr>
                                                                @if($slot->size_value)
                                                                    <td style="padding-right: 15px;">
                                                                        <strong>Size:</strong> {{ trim($slot->size_value) }}
                                                                    </td>
                                                                @endif
                                                                @if($slot->color_value)
                                                                    <td style="vertical-align: middle;">
                                                                        <strong style="margin-right: 5px;">Color:</strong>
                                                                        <span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: {{ trim($slot->color_value) }}; border: 1px solid #e5e7eb; vertical-align: middle; margin-right: 4px; margin-bottom: 2px;"></span>
                                                                        {{ trim($slot->color_value) }}
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </td>
                                                <td style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: center;">{{ $slot->quantity }}</td>
                                                <td style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: right;">₹{{ number_format($slot->product_rate, 2) }}</td>
                                                <td style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: right;">₹{{ number_format($slot->product_total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: center;">Order details will be provided shortly</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Shipping Details -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Shipping Details</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; width: 40%;">Shipping Address</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $order->order_name ?? 'Address will be updated soon' }}</td>
                                </tr>
                                @if($order->order_notes)
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Order Notes</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $order->order_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Action Button -->
                    <tr>
                        <td style="padding: 0 20px; text-align: center;">
                            <a href="{{ url('/admin/orders/' . $order->order_id) }}" style="display: inline-block; background-color: #e11e12; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 4px; margin: 20px 0;">View Order in Admin Panel</a>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="text-align: center; padding: 20px; font-size: 12px; color: #666666; border-top: 1px solid #e5e7eb; margin-top: 30px;">
                            <p style="margin: 5px 0;"><strong>FM Uniforms</strong></p>
                            <p style="margin: 5px 0;">Support: <a href="mailto:support@fmuniforms.com" style="color: #e11e12; text-decoration: none;">support@fmuniforms.com</a></p>
                            <p style="margin: 5px 0;">Website: <a href="{{ url('/') }}" style="color: #e11e12; text-decoration: none;">{{ url('/') }}</a></p>
                            <p style="margin: 10px 0 0 0; color: #999999;">© {{ date('Y') }} FM Uniforms. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
