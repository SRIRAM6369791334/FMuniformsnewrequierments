@extends('layouts.app')

@section('title', 'Privacy Policy | FM Uniforms')

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-[1200px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
    <a href="{{ url('/') }}" class="hover:text-[#b78a46] transition-colors">Home</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <span class="text-gray-800 font-semibold">Privacy Policy</span>
</div>

{{-- Hero Banner --}}
<div class="bg-[#051121] text-white py-14 px-4">
    <div class="max-w-[1200px] mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 text-[#b78a46] text-[0.65rem] font-bold uppercase tracking-[0.2em] px-4 py-2 rounded-full mb-5">
            <i class="ph ph-lock-key"></i> Privacy Document
        </div>
        <h1 class="text-3xl lg:text-4xl font-heading font-extrabold tracking-tight mb-3">Privacy Policy</h1>
        <p class="text-gray-400 text-sm max-w-xl mx-auto">Your privacy is our priority at FM Uniforms. We handle your data with full transparency and responsibility.</p>
    </div>
</div>

{{-- Content --}}
<div class="bg-[#f4f5f7] py-14 px-4">
    <div class="max-w-[860px] mx-auto space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-shield-check"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Our Commitment</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">FM Uniforms / FM11 Fashion Mart respects your privacy and is committed to protecting your personal information. This policy outlines how we handle your data when you interact with our website.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-database"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Information Collection</h2>
                    <p class="text-sm text-gray-600 leading-relaxed mb-3">We collect basic details only to process orders, deliveries, and provide customer support:</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Name and contact information</li>
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Email address and shipping details</li>
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Order history and communication preferences</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-orange-50 text-[#b78a46] rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-lock-key"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Payment Security</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Payments are securely processed through <strong>Razorpay</strong>. We do not store card, UPI, or banking details on our servers, ensuring your financial information remains private and secure.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-share-network"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Data Sharing</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Your information is <strong>never sold or shared</strong> with third parties, except with payment gateways, logistics partners, or legal authorities when required by law.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-user-check"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Your Consent</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">By using our website, you agree to this privacy policy. We may update this policy periodically to reflect changes in our practices or for legal reasons.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-[#051121] text-white rounded-xl p-7 flex flex-col md:flex-row items-center justify-between gap-5">
            <div>
                <h3 class="font-heading font-bold text-lg mb-1">Questions about your privacy?</h3>
                <p class="text-gray-400 text-sm">Have questions about our privacy practices? We're here to help.</p>
            </div>
            <a href="{{ url('/contact') }}" class="shrink-0 bg-[#b78a46] hover:bg-[#9b7337] text-white font-bold text-xs px-6 py-3 rounded-md uppercase tracking-widest transition-colors whitespace-nowrap">
                Contact Us
            </a>
        </div>

    </div>
</div>

@endsection
