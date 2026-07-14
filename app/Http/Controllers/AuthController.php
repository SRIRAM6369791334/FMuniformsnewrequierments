<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Transfer guest cart items to user account (IP-based to user_id)
            $userId = Auth::id();
            $ipAddress = $request->ip();
            $transferredCount = Cart::transferGuestCart($ipAddress, $userId);
            if ($transferredCount > 0) {
                \Log::info('Guest cart transferred on login', [
                    'user_id' => $userId,
                    'ip_address' => $ipAddress,
                    'transferred_count' => $transferredCount
                ]);
            }

            // Check if there's a return URL (e.g., from checkout)
            $returnUrl = session('checkout_return');
            if ($returnUrl && $returnUrl === 'checkout') {
                // Clear the session and redirect back to checkout
                session()->forget('checkout_return');
                return redirect()->route('checkout')->with('is_return_from_login', true);
            }

            return redirect('/')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }

    public function showRegister()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:50',
            'phone_number' => 'required|regex:/^[0-9]{10}$/|unique:users,phone_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->first_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ip_address' => $request->ip(),
        ]);

        Auth::login($user);

        // Transfer guest cart items to new user account (IP-based to user_id)
        $ipAddress = $request->ip();
        $transferredCount = Cart::transferGuestCart($ipAddress, $user->id);
        if ($transferredCount > 0) {
            \Log::info('Guest cart transferred on registration', [
                'user_id' => $user->id,
                'ip_address' => $ipAddress,
                'transferred_count' => $transferredCount
            ]);
        }

        // Check if there's a return URL (e.g., from checkout)
        $returnUrl = session('checkout_return');
        if ($returnUrl && $returnUrl === 'checkout') {
            // Clear the session and redirect back to checkout
            session()->forget('checkout_return');
            return redirect()->route('checkout')->with('is_return_from_login', true);
        }

        return redirect('/')->with('success', 'Registration successful!');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate 6-digit OTP as string
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing OTP for this email
        PasswordReset::where('email', $request->email)->delete();

        // Store OTP in database
        PasswordReset::create([
            'email' => $request->email,
            'token' => \Illuminate\Support\Str::random(64), // Provide required token field
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10)
        ]);

        // Debug logging (without sensitive OTP value)
        \Log::info('Password reset OTP sent', [
            'email' => $request->email,
            'expires_at' => now()->addMinutes(10)->toDateTimeString()
        ]);

        // Send OTP via notification
        $user->notify(new \App\Notifications\ResetPasswordNotification($otp));

        return back()->with([
            'otp_sent' => true,
            'message' => 'OTP sent to your email',
            'reset_email' => $request->email
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with([
                'otp_sent' => true,
                'reset_email' => $request->email
            ]);
        }

        $requestOtp = $request->otp;
        $requestEmail = $request->email;

        // Find the password reset record
        $passwordReset = PasswordReset::where('email', $requestEmail)->first();

        // Check if OTP record exists
        if (!$passwordReset) {
            return back()->withErrors(['otp' => 'No active OTP request found for this email. Please request a new one.'])->with([
                'otp_sent' => false,
                'reset_email' => $requestEmail
            ]);
        }

        // Check if OTP has expired
        if ($passwordReset->isExpired()) {
            $passwordReset->delete(); // Clean up expired record
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.'])->with([
                'otp_sent' => false,
                'reset_email' => $requestEmail
            ]);
        }

        // Check if OTP matches
        if ($passwordReset->otp !== $requestOtp) {
            $passwordReset->increment('attempts');
            $remaining = 3 - $passwordReset->attempts;

            if ($remaining <= 0) {
                $passwordReset->delete();
                return back()->withErrors(['otp' => 'Maximum attempts reached. This OTP has been invalidated. Please request a new one.'])->with([
                    'otp_sent' => false,
                    'reset_email' => $requestEmail
                ]);
            }

            return back()->withErrors(['otp' => "Invalid OTP. You have {$remaining} attempts left."])->with([
                'otp_sent' => true,
                'reset_email' => $requestEmail
            ]);
        }

        // OTP is valid, reset password
        $user = User::where('email', $requestEmail)->first();
        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.'])->with([
                'otp_sent' => true,
                'reset_email' => $requestEmail
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Clean up the used OTP record
        $passwordReset->delete();

        return redirect('/login')->with('success', 'Password reset successful! Please login with your new password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


}
