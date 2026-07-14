@extends('layouts.app')
@section('content')

<!-- Tailwind Play CDN & Config (Preflight Disabled to preserve theme layout) -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        corePlugins: {
            preflight: false,
        },
        theme: {
            extend: {
                colors: {
                    'brand-navy': '#0f172a',
                    'brand-gold': '#c99355',
                }
            }
        }
    }
</script>

<style>
    .fm-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        font-size: 0.875rem !important;
        color: #1e293b !important;
        background-color: #f8fafc !important;
        outline: none !important;
        transition: all 0.2s ease !important;
        box-sizing: border-box !important;
        height: auto !important;
    }
    .fm-input:focus {
        border-color: #c99355 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(201, 147, 85, 0.15) !important;
    }
    .password-wrapper {
        position: relative;
        width: 100%;
    }
    .password-wrapper input {
        padding-right: 2.75rem !important;
    }
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #64748b;
        z-index: 10;
        transition: color 0.2s ease;
    }
    .password-toggle:hover {
        color: #0f172a;
    }
    /* Link hover animation */
    .premium-link {
        font-size: 0.875rem;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .premium-link:hover {
        color: #c99355;
        transform: translateX(3px);
    }
</style>

<!-- Breadcrumb Area -->
<section class="bg-gray-50 border-b border-gray-200/80 py-4 mb-10">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-xs text-gray-500 font-medium">
            <a href="{{ url('/') }}" class="hover:text-brand-gold transition-colors">Home</a>
            <span class="mx-2 text-gray-400">|</span>
            <span class="text-gray-900 font-semibold">Login</span>
        </div>
    </div>
</section>

<!-- Login Area -->
<section class="pb-24 pt-24">
    <div class="max-w-[1400px] mx-auto px-4">
        <div class="flex flex-col items-center justify-center">
            
            <!-- Center Card -->
            <div class="w-full max-w-md bg-white rounded-2xl border border-gray-200/80 p-6 sm:p-10 shadow-sm transition-all duration-300 hover:shadow-md">
                
                <!-- Section Title -->
                <div class="text-center mb-8">
                    <h2 class="font-sans font-bold text-2xl sm:text-3xl text-brand-navy tracking-tight uppercase">
                        Login <span class="text-brand-gold font-normal">Account</span>
                    </h2>
                    <p class="text-xs text-gray-400 mt-2">Access your wholesale dashboard & B2B orders</p>
                </div>

                <!-- Forms Container -->
                <div class="space-y-6">
                    
                    <!-- 1. LOGIN FORM -->
                    <form id="login-form" action="{{ url('/login') }}" method="post" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Email Address *</label>
                            <input type="email" placeholder="e.g. rajesh@hospital.com" name="email" class="fm-input" required>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="block text-[0.7rem] font-bold text-brand-navy uppercase tracking-wider">Password *</label>
                            </div>
                            <div class="password-wrapper">
                                <input type="password" placeholder="••••••••" name="password" class="password-field fm-input" required>
                                <i class="fas fa-eye password-toggle"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-lg transition-colors uppercase tracking-widest shadow-md">
                                LOG IN
                            </button>
                        </div>
                        <div class="text-center pt-2">
                            <a href="#" id="forgot-password-link" class="premium-link">Forgot Password?</a>
                        </div>
                    </form>

                    <!-- 2. FORGOT PASSWORD FORM -->
                    <form id="forgot-password-form" action="{{ url('/forgot-password') }}" method="post" class="space-y-5" style="display:none;">
                        @csrf
                        <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 text-xs text-[#a16207] leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i> Enter your registered email address below, and we will send you an OTP to reset your password.
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Email Address *</label>
                            <input type="email" placeholder="e.g. rajesh@hospital.com" name="email" class="fm-input" required>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-lg transition-colors uppercase tracking-widest shadow-md">
                                SEND OTP
                            </button>
                        </div>
                        <div class="text-center pt-2">
                            <a href="#" id="back-to-login-link" class="premium-link">
                                <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to Login
                            </a>
                        </div>
                    </form>

                    <!-- 3. VERIFY OTP FORM -->
                    <form id="verify-otp-form" action="{{ url('/verify-otp') }}" method="post" class="space-y-5" style="display:none;">
                        @csrf
                        <input type="hidden" name="email" id="verify-email">
                        
                        <div class="bg-sky-50 border border-sky-100 rounded-lg p-4 text-xs text-[#0369a1] leading-relaxed">
                            <i class="fas fa-check-circle mr-1"></i> OTP has been sent successfully. Please check your inbox.
                        </div>
                        
                        <div>
                            <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Enter OTP *</label>
                            <input type="text" placeholder="e.g. 123456" name="otp" class="fm-input text-center tracking-widest font-bold" required>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">New Password *</label>
                            <div class="password-wrapper">
                                <input type="password" placeholder="••••••••" name="password" class="password-field fm-input" required>
                                <i class="fas fa-eye password-toggle"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Confirm Password *</label>
                            <div class="password-wrapper">
                                <input type="password" placeholder="••••••••" name="password_confirmation" class="password-field fm-input" required>
                                <i class="fas fa-eye password-toggle"></i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-lg transition-colors uppercase tracking-widest shadow-md">
                                RESET PASSWORD
                            </button>
                        </div>
                        <div class="text-center pt-2">
                            <a href="#" id="back-to-forgot-link" class="premium-link">
                                <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to Forgot Password
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Bottom Prompt -->
            <div class="w-full max-w-md mt-6 text-center bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <span class="text-sm text-gray-500">Don't have an account?</span>
                <a href="{{ url('/register') }}" class="ml-2 text-brand-gold hover:text-yellow-600 font-bold text-sm uppercase tracking-wider transition-colors hover:underline">
                    Create Account
                </a>
            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
window.otpSent = {{ session('otp_sent') ? 'true' : 'false' }};
window.resetEmail = '{{ session('reset_email', '') }}';
</script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/js/success.js') }}"></script>
<script src="{{ asset('assets/js/forgot-password.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.password-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    });
});
</script>
@endsection
