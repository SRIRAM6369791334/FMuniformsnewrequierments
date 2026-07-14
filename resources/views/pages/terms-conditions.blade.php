@extends('layouts.app')

@section('title', 'Terms & Conditions | FM Uniforms')

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-[1200px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
    <a href="{{ url('/') }}" class="hover:text-[#b78a46] transition-colors">Home</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <span class="text-gray-800 font-semibold">Terms &amp; Conditions</span>
</div>

{{-- Hero Banner --}}
<div class="bg-[#051121] text-white py-14 px-4">
    <div class="max-w-[1200px] mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 text-[#b78a46] text-[0.65rem] font-bold uppercase tracking-[0.2em] px-4 py-2 rounded-full mb-5">
            <i class="ph ph-file-text"></i> Legal Document
        </div>
        <h1 class="text-3xl lg:text-4xl font-heading font-extrabold tracking-tight mb-3">Terms &amp; Conditions</h1>
        <p class="text-gray-400 text-sm max-w-xl mx-auto">Guidelines for using our website and services. Please read these carefully before placing an order.</p>
    </div>
</div>

{{-- Content --}}
<div class="bg-[#f4f5f7] py-14 px-4">
    <div class="max-w-[860px] mx-auto space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-info"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Acceptance of Terms</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">By accessing and using this website, you agree to follow and be bound by the terms and conditions outlined here. If you do not agree, please do not use our site.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-t-shirt"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Products &amp; Services</h2>
                    <p class="text-sm text-gray-600 leading-relaxed mb-3">We supply ready-made and customized uniforms including medical, hospitality, corporate, and school uniforms. Please note:</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Product colors and fabric shades may slightly vary due to lighting and screen resolution.</li>
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Small variations are possible due to different production batches.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-orange-50 text-[#b78a46] rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-currency-inr"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Orders &amp; Pricing</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Bulk and customized orders are confirmed only after <strong>advance payment</strong>. Prices are subject to change without prior notice, and GST is applicable as per government norms.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-prohibit"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Cancellations</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Once production starts, bulk and customized orders <strong>cannot be canceled</strong>. We recommend finalizing all details before confirming the order.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-copyright"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Intellectual Property</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">All website content, designs, images, and logos are the property of <strong>FM Uniforms</strong>. Unauthorized use or reproduction is strictly prohibited.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-[#051121] text-white rounded-xl p-7 flex flex-col md:flex-row items-center justify-between gap-5">
            <div>
                <h3 class="font-heading font-bold text-lg mb-1">Questions about our terms?</h3>
                <p class="text-gray-400 text-sm">Our team is happy to clarify any clause or condition.</p>
            </div>
            <a href="{{ url('/contact') }}" class="shrink-0 bg-[#b78a46] hover:bg-[#9b7337] text-white font-bold text-xs px-6 py-3 rounded-md uppercase tracking-widest transition-colors whitespace-nowrap">
                Contact Us
            </a>
        </div>

    </div>
</div>

@endsection