@extends('layouts.app')

@section('title', 'Refund & Return Policy | FM Uniforms')

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-[1200px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
    <a href="{{ url('/') }}" class="hover:text-[#b78a46] transition-colors">Home</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <span class="text-gray-800 font-semibold">Refund & Return Policy</span>
</div>

{{-- Hero Banner --}}
<div class="bg-[#051121] text-white py-14 px-4">
    <div class="max-w-[1200px] mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 text-[#b78a46] text-[0.65rem] font-bold uppercase tracking-[0.2em] px-4 py-2 rounded-full mb-5">
            <i class="ph ph-shield-check"></i> Policy Document
        </div>
        <h1 class="text-3xl lg:text-4xl font-heading font-extrabold tracking-tight mb-3">Refund &amp; Return Policy</h1>
        <p class="text-gray-400 text-sm max-w-xl mx-auto">Transparency in our returns and refund process. We believe in fair and clear policies for every customer.</p>
    </div>
</div>

{{-- Content --}}
<div class="bg-[#f4f5f7] py-14 px-4">
    <div class="max-w-[860px] mx-auto space-y-5">

        {{-- Section Card --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-arrow-counter-clockwise"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Eligibility for Returns</h2>
                    <p class="text-sm text-gray-600 leading-relaxed mb-3">Ready-made products are eligible for return only in case of manufacturing defects. Please note:</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Return requests must be raised within <strong>48 hours</strong> of delivery.</li>
                        <li class="flex items-start gap-2"><i class="ph ph-check-circle text-green-500 mt-0.5 shrink-0"></i> Items must be in original condition with tags intact.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-x-circle"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Non-Returnable Items</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Customized and bulk orders are <strong>non-returnable and non-refundable</strong> as they are produced specifically to your requirements.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-clock-countdown"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Processing Refunds</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Approved refunds will be processed within <strong>10–15 working days</strong> and credited back to the original payment method used during purchase.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-orange-50 text-[#b78a46] rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-file-text"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Order Cancellations</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">Orders can be canceled only <strong>before production begins</strong>. Once fabric is cut or production is initialized, cancellations are not possible.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-7">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center text-xl shrink-0">
                    <i class="ph ph-warning-circle"></i>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-[#051121] text-base mb-2 uppercase tracking-wide">Damages &amp; Issues</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">For damaged or incorrect products, customers must share <strong>clear images within 48 hours</strong> of delivery for verification. We will expedite a replacement or refund upon approval.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-[#051121] text-white rounded-xl p-7 flex flex-col md:flex-row items-center justify-between gap-5">
            <div>
                <h3 class="font-heading font-bold text-lg mb-1">Have a question about returns?</h3>
                <p class="text-gray-400 text-sm">Our support team is available Mon–Sat, 9am to 6pm.</p>
            </div>
            <a href="{{ url('/contact') }}" class="shrink-0 bg-[#b78a46] hover:bg-[#9b7337] text-white font-bold text-xs px-6 py-3 rounded-md uppercase tracking-widest transition-colors whitespace-nowrap">
                Contact Support
            </a>
        </div>

    </div>
</div>

@endsection
