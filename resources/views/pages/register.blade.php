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
</style>

<!-- Breadcrumb Area -->
<section class="bg-gray-50 border-b border-gray-200/80 py-4 mb-10">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-xs text-gray-500 font-medium">
            <a href="{{ url('/') }}" class="hover:text-brand-gold transition-colors">Home</a>
            <span class="mx-2 text-gray-400">|</span>
            <span class="text-gray-900 font-semibold">Register</span>
        </div>
    </div>
</section>

<!-- Register Area -->
<section class="pb-24 pt-24">
    <div class="max-w-[1400px] mx-auto px-4">
        <div class="flex flex-col items-center justify-center">
            
            <!-- Center Card -->
            <div class="w-full max-w-md bg-white rounded-2xl border border-gray-200/80 p-6 sm:p-10 shadow-sm transition-all duration-300 hover:shadow-md">
                
                <!-- Section Title -->
                <div class="text-center mb-8">
                    <h2 class="font-sans font-bold text-2xl sm:text-3xl text-brand-navy tracking-tight uppercase">
                        Create <span class="text-brand-gold font-normal">Account</span>
                    </h2>
                    <p class="text-xs text-gray-400 mt-2">Sign up for wholesale orders & customized uniforms</p>
                </div>

                <!-- Form Container -->
                <form id="register-form" action="{{ url('/register') }}" method="post" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">First Name *</label>
                        <input type="text" placeholder="e.g. Rajesh" name="first_name" class="fm-input" required>
                    </div>
                    <div>
                        <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Phone Number *</label>
                        <input type="text" placeholder="e.g. 9876543210" name="phone_number" class="fm-input" required>
                    </div>
                    <div>
                        <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Email Address *</label>
                        <input type="email" placeholder="e.g. rajesh@hospital.com" name="email" class="fm-input" required>
                    </div>
                    <div>
                        <label class="block text-[0.7rem] font-bold text-brand-navy mb-1.5 uppercase tracking-wider">Password *</label>
                        <div class="password-wrapper">
                            <input type="password" placeholder="••••••••" name="password" id="password" class="fm-input" required>
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-lg transition-colors uppercase tracking-widest shadow-md">
                            CREATE ACCOUNT
                        </button>
                    </div>
                </form>

            </div>

            <!-- Bottom Prompt -->
            <div class="w-full max-w-md mt-6 text-center bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <span class="text-sm text-gray-500">Already have account?</span>
                <a href="{{ url('/login') }}" class="ml-2 text-brand-gold hover:text-yellow-600 font-bold text-sm uppercase tracking-wider transition-colors hover:underline">
                    Login now
                </a>
            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/js/success.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const featureForm = document.getElementById('register-form');
    if (featureForm) {
        featureForm.addEventListener('submit', function() {
            Swal.fire({
                title: 'Creating Account...',
                text: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }

    // Password Toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection
