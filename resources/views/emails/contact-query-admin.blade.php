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
                            <h2 style="text-align: center; color: #00274D; margin: 20px 0;">New Contact Form Submission</h2>
                            <p style="text-align: center; font-size: 14px; color: #666666; margin: 10px 0 30px 0;">
                                A new inquiry has been received through the contact form on FM Uniforms. Please respond to the customer as soon as possible.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Contact Information -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Contact Information</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; width: 40%;">Full Name</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $contactQuery->first_name }} {{ $contactQuery->last_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Email</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;"><a href="mailto:{{ $contactQuery->email }}" style="color: #e11e12; text-decoration: none;">{{ $contactQuery->email }}</a></td>
                                </tr>
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Subject</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; color: #e11e12;">{{ $contactQuery->subject }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Submitted On</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $contactQuery->created_at->format('F j, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Message -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Message</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; line-height: 1.6;">{!! nl2br(e($contactQuery->message)) !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    @if($contactQuery->user_id)
                    <!-- Associated User -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h3 style="color: #333333; margin: 20px 0 10px 0; font-size: 16px;">Registered User</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600; width: 40%;">User ID</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $contactQuery->user_id }}</td>
                                </tr>
                                @if($contactQuery->user)
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; font-weight: 600;">Registered Email</td>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb;">{{ $contactQuery->user->email }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                    @endif
                    
                    <!-- Action Button -->
                    <tr>
                        <td style="padding: 0 20px; text-align: center;">
                            <a href="mailto:{{ $contactQuery->email }}?subject=Re: {{ urlencode($contactQuery->subject) }}" style="display: inline-block; background-color: #e11e12; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 4px; margin: 20px 0;">Reply to Customer</a>
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
