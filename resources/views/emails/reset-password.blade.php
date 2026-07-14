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
                    <!-- Header with Logo -->
                    <tr>
                        <td style="text-align: center; padding: 20px 0;">
                            <img src="{{ url('/media/images/logo.png') }}" alt="FM Uniforms" style="max-width: 180px; height: auto;">
                            <div style="margin: 20px 0; border-bottom: 1px solid #e5e7eb;"></div>
                        </td>
                    </tr>
                    
                    <!-- Title -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <h2 style="text-align: center; color: #00274D; font-family: Arial, Helvetica, sans-serif; margin: 20px 0;">Password Reset Request</h2>
                            <p style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #666666; margin: 10px 0 30px 0;">
                                You requested a password reset for your FM Uniforms account. Use the OTP code below to proceed.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- OTP Table -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid #e5e7eb; margin: 20px 0;">
                                <tr style="background-color: #fafafa;">
                                    <td style="padding: 20px 15px; border: 1px solid #e5e7eb; text-align: center;">
                                        <p style="margin: 0 0 10px 0; font-weight: 600; color: #333333;">Your OTP Code</p>
                                        <p style="margin: 0; font-size: 32px; font-weight: 700; color: #e11e12; letter-spacing: 8px;">{{ $otp }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border: 1px solid #e5e7eb; text-align: center; color: #666666;">
                                        <small>This OTP will expire in <strong>10 minutes</strong></small>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Security Notice -->
                    <tr>
                        <td style="padding: 0 20px;">
                            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0;">
                                <p style="margin: 5px 0; color: #856404;"><strong>Security Notice:</strong></p>
                                <p style="margin: 5px 0; color: #856404;">• Never share this OTP with anyone</p>
                                <p style="margin: 5px 0; color: #856404;">• If you did not request this reset, please ignore this email</p>
                                <p style="margin: 5px 0; color: #856404;">• Your password will not change until you complete the reset process</p>
                            </div>
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
