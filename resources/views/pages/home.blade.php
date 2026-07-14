@extends('layouts.app')

@section('title', 'FM Uniforms — One Brand. Every Professional.')

@section('styles')
<style>
    /* ── Ticker scroll ── */
    @keyframes ticker {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .ticker-track { animation: ticker 28s linear infinite; }
    .ticker-track:hover { animation-play-state: paused; }

    /* ── Counter animation ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.7s ease both; }

    /* ── Hero shimmer ── */
    @keyframes shimmer {
        0%, 100% { opacity: 0.06; }
        50%       { opacity: 0.12; }
    }
    .hero-shimmer { animation: shimmer 6s ease-in-out infinite; }

    /* ── Card hover ── */
    .hover-lift { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 16px 40px -8px rgba(0,0,0,0.12); }

    /* ── Process connector line ── */
    .step-connector { flex: 1; height: 2px; background: linear-gradient(90deg, #b78a46, #d4a866); border-radius: 4px; margin-top: -2px; }

    /* ── Testimonial star ── */
    .star-fill { color: #f59e0b; }

    /* ── Section tag ── */
    .section-tag {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f5f0e8; border: 1px solid #e2c898;
        color: #8a6520; font-size: 0.6rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.2em;
        padding: 6px 14px; border-radius: 999px;
    }
</style>
@endsection

@section('content')

{{-- ════════════════════════════════════════ --}}
{{-- 1. HERO SECTION --}}
{{-- ════════════════════════════════════════ --}}
<section class="relative bg-[#ebe6df] overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="hero-shimmer absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-[#b78a46] translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>
    <div class="hero-shimmer absolute bottom-0 left-0 w-[300px] h-[300px] rounded-full bg-[#051121] -translate-x-1/2 translate-y-1/3 pointer-events-none" style="animation-delay:3s"></div>

    <div class="container mx-auto px-4 lg:px-8 flex flex-col md:flex-row items-center pt-12 md:pt-16 lg:pt-20 pb-0 relative z-10">
        {{-- Left copy --}}
        <div class="w-full md:w-1/2 space-y-6 mb-10 md:mb-20 pr-4">
            <div class="section-tag"><i class="ph ph-star-four text-[10px]"></i> Est. 2014 · Karur, Tamil Nadu</div>

            <h1 class="font-heading text-4xl md:text-5xl lg:text-[62px] font-extrabold leading-[1.05] text-[#051121] tracking-tight">
                ONE BRAND.<br>
                FOUR WORLDS.<br>
                BUILT FOR<br>
                <span class="text-[#b78a46]">EVERY PROFESSION.</span>
            </h1>

            <p class="text-gray-600 max-w-md text-base leading-relaxed">
                Premium uniforms &amp; branding for <strong>healthcare</strong>, <strong>hospitality</strong>, <strong>corporate</strong> and <strong>schools</strong>. Designed for identity. Built for performance.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ url('/shop') }}" class="bg-[#051121] hover:bg-[#0f2340] text-white font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-sm transition-all shadow-lg shadow-[#051121]/20 flex items-center gap-2">
                    <i class="ph ph-storefront"></i> Shop Now
                </a>
                <a href="{{ url('/bulkorder') }}" class="border-2 border-[#051121] text-[#051121] hover:bg-[#051121] hover:text-white font-bold text-xs uppercase tracking-widest px-8 py-4 rounded-sm transition-all flex items-center gap-2">
                    <i class="ph ph-briefcase"></i> Get Bulk Quote
                </a>
            </div>

            {{-- Trust chips --}}
            <div class="flex flex-wrap gap-3 pt-2">
                <div class="flex items-center gap-2 bg-white/80 border border-gray-250 rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#051121]">
                    <i class="ph ph-shield-check text-[#b78a46]"></i> Premium Quality
                </div>
                <div class="flex items-center gap-2 bg-white/80 border border-gray-250 rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#051121]">
                    <i class="ph ph-pencil-simple-line text-[#b78a46]"></i> Custom Branding
                </div>
                <div class="flex items-center gap-2 bg-white/80 border border-gray-250 rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#051121]">
                    <i class="ph ph-users text-[#b78a46]"></i> Bulk Specialist
                </div>
                <div class="flex items-center gap-2 bg-white/80 border border-gray-250 rounded-full px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#051121]">
                    <i class="ph ph-truck text-[#b78a46]"></i> PAN India Delivery
                </div>
            </div>
        </div>

        {{-- Right image --}}
        <div class="w-full md:w-1/2 relative flex justify-end items-end self-end h-[380px] md:h-[520px] lg:h-[620px]">
            {{-- Floating stat cards --}}
            <div class="absolute top-10 left-4 bg-white rounded-xl shadow-xl border border-gray-100 px-4 py-3 z-20 hidden md:flex items-center gap-3 fade-up">
                <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center text-green-600"><i class="ph ph-check-circle text-lg"></i></div>
                <div><div class="font-heading font-extrabold text-[#051121] text-lg leading-none">2 Lakh+</div><div class="text-[10px] text-gray-500 uppercase tracking-wide font-bold">Happy Customers</div></div>
            </div>
            <div class="absolute bottom-24 left-0 bg-[#051121] text-white rounded-xl shadow-xl px-4 py-3 z-20 hidden md:flex items-center gap-3 fade-up" style="animation-delay:0.3s">
                <div class="w-9 h-9 bg-[#b78a46]/20 rounded-full flex items-center justify-center text-[#b78a46]"><i class="ph ph-star text-lg"></i></div>
                <div><div class="font-heading font-extrabold text-white text-lg leading-none">4.8 / 5</div><div class="text-[10px] text-gray-400 uppercase tracking-wide font-bold">Client Rating</div></div>
            </div>
            <img src="{{ asset('images/hero.png') }}" alt="FM Uniforms Professionals" class="object-contain object-bottom h-full w-full relative z-10 mix-blend-multiply">
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 2. SCROLLING TRUST TICKER --}}
{{-- ════════════════════════════════════════ --}}
<div class="bg-[#051121] text-white py-3 overflow-hidden border-y border-gray-800">
    <div class="flex whitespace-nowrap ticker-track gap-0">
        @php
            $ticks = [
                ['icon'=>'ph-hospital','label'=>'Healthcare Uniforms'],
                ['icon'=>'ph-chef-hat','label'=>'Hospitality Wear'],
                ['icon'=>'ph-briefcase','label'=>'Corporate Workwear'],
                ['icon'=>'ph-graduation-cap','label'=>'School Uniforms'],
                ['icon'=>'ph-needle','label'=>'Custom Embroidery'],
                ['icon'=>'ph-package','label'=>'Bulk Order Experts'],
                ['icon'=>'ph-truck','label'=>'PAN India Delivery'],
                ['icon'=>'ph-star','label'=>'4.8★ Rated Service'],
                ['icon'=>'ph-hospital','label'=>'Healthcare Uniforms'],
                ['icon'=>'ph-chef-hat','label'=>'Hospitality Wear'],
                ['icon'=>'ph-briefcase','label'=>'Corporate Workwear'],
                ['icon'=>'ph-graduation-cap','label'=>'School Uniforms'],
                ['icon'=>'ph-needle','label'=>'Custom Embroidery'],
                ['icon'=>'ph-package','label'=>'Bulk Order Experts'],
                ['icon'=>'ph-truck','label'=>'PAN India Delivery'],
                ['icon'=>'ph-star','label'=>'4.8★ Rated Service'],
            ];
        @endphp
        @foreach($ticks as $tick)
        <span class="inline-flex items-center gap-2 px-8 text-[11px] font-bold uppercase tracking-[0.18em]">
            <i class="ph {{ $tick['icon'] }} text-[#b78a46]"></i>
            {{ $tick['label'] }}
            <span class="text-gray-600 mx-2">·</span>
        </span>
        @endforeach
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{-- 3. BRANDS GRID --}}
{{-- ════════════════════════════════════════ --}}
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 text-white">
    {{-- MediQo --}}
    <a href="{{ url('/categories/mediqo') }}" class="relative group min-h-[400px] p-10 flex flex-col items-center justify-between text-center border-r border-white/10 overflow-hidden cursor-pointer transition-all duration-300">
        <img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?auto=format&fit=crop&w=500&h=700&q=80" alt="MediQo Medical Uniforms" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 -z-20">
        <div class="absolute inset-0 bg-[#08545e]/90 group-hover:bg-[#08545e]/80 transition-colors duration-300 -z-10"></div>
        <div class="mb-5 flex flex-col items-center">
            <span class="text-[0.55rem] font-bold tracking-[0.3em] text-white/70 uppercase mb-2">FM PRESENTS</span>
            <h3 class="font-heading text-3xl font-black tracking-[0.12em] uppercase text-white leading-none">MEDIQO</h3>
            <div class="w-12 h-0.5 bg-white/30 my-3"></div>
            <p class="text-[0.6rem] uppercase tracking-[0.25em] opacity-80 font-bold">ENGINEERED FOR CARE</p>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-8 w-full text-center">
            @foreach(['Scrubs','Lab Coats','OT Wear','Nurse Wear'] as $item)
            <div class="bg-white/15 border border-white/25 rounded-lg py-2 px-1 text-[9px] font-bold uppercase tracking-wide group-hover:bg-white/35 transition">{{ $item }}</div>
            @endforeach
        </div>
        <div class="border border-white/40 group-hover:bg-white group-hover:text-fm-mediqo px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-2 transition-all">
            EXPLORE <i class="ph ph-arrow-right text-sm"></i>
        </div>
    </a>

    {{-- Hostra --}}
    <a href="{{ url('/categories/hostra') }}" class="relative group min-h-[400px] p-10 flex flex-col items-center justify-between text-center border-r border-white/10 overflow-hidden cursor-pointer transition-all duration-300">
        <img src="https://images.unsplash.com/photo-1581081859938-23ef7110e53a?auto=format&fit=crop&w=500&h=700&q=80" alt="Hostra Hospitality Wear" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 -z-20">
        <div class="absolute inset-0 bg-[#471d23]/90 group-hover:bg-[#471d23]/80 transition-colors duration-300 -z-10"></div>
        <div class="mb-5 flex flex-col items-center">
            <span class="text-[0.55rem] font-bold tracking-[0.3em] text-[#d1b08c]/70 uppercase mb-2">FM PRESENTS</span>
            <h3 class="font-heading text-3xl font-black tracking-[0.12em] uppercase text-white leading-none">HOSTR<span class="text-[#d1b08c]">A</span></h3>
            <div class="w-12 h-0.5 bg-[#d1b08c]/30 my-3"></div>
            <p class="text-[0.6rem] uppercase tracking-[0.25em] text-[#d1b08c]/80 font-bold">COMFORT BY NATURE</p>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-8 w-full text-center">
            @foreach(['Front Office','Housekeeping','Chef Wear','Service Staff'] as $item)
            <div class="bg-white/15 border border-white/25 rounded-lg py-2 px-1 text-[9px] font-bold uppercase tracking-wide group-hover:bg-white/35 transition">{{ $item }}</div>
            @endforeach
        </div>
        <div class="border border-white/40 group-hover:bg-white group-hover:text-fm-hostra px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-2 transition-all">
            EXPLORE <i class="ph ph-arrow-right text-sm"></i>
        </div>
    </a>

    {{-- Workon --}}
    <a href="{{ url('/categories/workon') }}" class="relative group min-h-[400px] p-10 flex flex-col items-center justify-between text-center border-r border-white/10 overflow-hidden cursor-pointer transition-all duration-300">
        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=500&h=700&q=80" alt="Workon Corporate Wear" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 -z-20">
        <div class="absolute inset-0 bg-[#1b1b1b]/90 group-hover:bg-[#1b1b1b]/80 transition-colors duration-300 -z-10"></div>
        <div class="mb-5 flex flex-col items-center">
            <span class="text-[0.55rem] font-bold tracking-[0.3em] text-[#e2c595]/70 uppercase mb-2">FM PRESENTS</span>
            <h3 class="font-heading text-3xl font-black tracking-[0.12em] uppercase text-white leading-none">WORK<span class="text-[#e2c595]">ON</span></h3>
            <div class="w-12 h-0.5 bg-[#e2c595]/30 my-3"></div>
            <p class="text-[0.6rem] uppercase tracking-[0.25em] text-[#e2c595]/80 font-bold">MADE FOR WORK</p>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-8 w-full text-center">
            @foreach(['Shirts','Trousers','Blazers','Polos'] as $item)
            <div class="bg-white/15 border border-white/25 rounded-lg py-2 px-1 text-[9px] font-bold uppercase tracking-wide group-hover:bg-white/35 transition">{{ $item }}</div>
            @endforeach
        </div>
        <div class="border border-white/40 group-hover:bg-white group-hover:text-fm-workon px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-2 transition-all">
            EXPLORE <i class="ph ph-arrow-right text-sm"></i>
        </div>
    </a>

    {{-- Scholix --}}
    <a href="{{ url('/categories/scholix') }}" class="relative group min-h-[400px] p-10 flex flex-col items-center justify-between text-center overflow-hidden cursor-pointer transition-all duration-300">
        <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=500&h=700&q=80" alt="Scholix School Uniforms" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 -z-20">
        <div class="absolute inset-0 bg-[#0b3254]/90 group-hover:bg-[#0b3254]/80 transition-colors duration-300 -z-10"></div>
        <div class="mb-5 flex flex-col items-center">
            <span class="text-[0.55rem] font-bold tracking-[0.3em] text-[#ffd166]/70 uppercase mb-2">FM PRESENTS</span>
            <h3 class="font-heading text-3xl font-black tracking-[0.12em] uppercase text-white leading-none">SCHOLIX</h3>
            <div class="w-12 h-0.5 bg-[#ffd166]/30 my-3"></div>
            <p class="text-[0.6rem] uppercase tracking-[0.25em] text-[#ffd166]/80 font-bold">SCHOOL IDENTITY SYSTEM</p>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-8 w-full text-center">
            @foreach(['Shirts','Trousers','Skirts','Ties & Belts'] as $item)
            <div class="bg-white/15 border border-white/25 rounded-lg py-2 px-1 text-[9px] font-bold uppercase tracking-wide group-hover:bg-white/35 transition">{{ $item }}</div>
            @endforeach
        </div>
        <div class="border border-white/40 group-hover:bg-white group-hover:text-fm-scholix px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-2 transition-all">
            EXPLORE <i class="ph ph-arrow-right text-sm"></i>
        </div>
    </a>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 4. STATS SECTION --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <div class="section-tag mb-4"><i class="ph ph-chart-bar text-[10px]"></i> Our Numbers</div>
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-[#051121] tracking-tight">Trusted by Professionals Across India</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
                $stats = [
                    ['value'=>'500+',     'label'=>'Schools Served',    'icon'=>'ph-buildings', 'color'=>'text-[#051121]',   'bg'=>'bg-[#051121]/5'],
                    ['value'=>'2 Lakh+',  'label'=>'Happy Students',    'icon'=>'ph-student',   'color'=>'text-[#051121]',  'bg'=>'bg-[#051121]/5'],
                    ['value'=>'1000+',    'label'=>'Corporate Clients', 'icon'=>'ph-briefcase', 'color'=>'text-[#051121]', 'bg'=>'bg-[#051121]/5'],
                    ['value'=>'10+',      'label'=>'Years of Trust',    'icon'=>'ph-trophy',    'color'=>'text-[#051121]',  'bg'=>'bg-[#051121]/5'],
                    ['value'=>'PAN India','label'=>'Delivery Network',  'icon'=>'ph-truck',     'color'=>'text-[#051121]',    'bg'=>'bg-[#051121]/5'],
                    ['value'=>'4.8★',     'label'=>'Client Rating',     'icon'=>'ph-star',      'color'=>'text-[#b78a46]',  'bg'=>'bg-[#b78a46]/10'],
                ];
            @endphp
            @foreach($stats as $s)
            <div class="hover-lift bg-white rounded-xl border border-gray-200 p-5 text-center shadow-sm">
                <div class="w-12 h-12 {{ $s['bg'] }} rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="ph {{ $s['icon'] }} {{ $s['color'] }} text-xl"></i>
                </div>
                <div class="font-heading font-extrabold text-2xl text-[#051121] leading-none mb-1">{{ $s['value'] }}</div>
                <div class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 5. FEATURED PRODUCTS --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-16 md:py-20 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <div class="section-tag mb-3"><i class="ph ph-sparkle text-[10px]"></i> Shop Best Sellers</div>
                <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-[#051121] tracking-tight">Featured Collections</h2>
                <p class="text-gray-500 text-sm mt-1">Explore our premium professional workwear range.</p>
            </div>
            
            {{-- Brand filter tabs --}}
            <div class="flex items-center gap-1.5 overflow-x-auto hide-scrollbar py-1">
                <button class="product-filter-btn active shrink-0 text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-full bg-[#051121] text-white transition-all" data-filter="all">All Brands</button>
                <button class="product-filter-btn shrink-0 text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-full border border-gray-200 text-gray-600 hover:border-[#051121] hover:text-[#051121] transition-all" data-filter="mediqo">MediQo</button>
                <button class="product-filter-btn shrink-0 text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-full border border-gray-200 text-gray-600 hover:border-[#051121] hover:text-[#051121] transition-all" data-filter="hostra">Hostra</button>
                <button class="product-filter-btn shrink-0 text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-full border border-gray-200 text-gray-600 hover:border-[#051121] hover:text-[#051121] transition-all" data-filter="workon">Workon</button>
                <button class="product-filter-btn shrink-0 text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-full border border-gray-200 text-gray-600 hover:border-[#051121] hover:text-[#051121] transition-all" data-filter="scholix">Scholix</button>
            </div>
        </div>

        <div class="product-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Product Card 1 - MediQo --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="mediqo">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <span class="absolute top-4 left-4 bg-emerald-100 text-emerald-800 text-[9px] font-extrabold uppercase px-2.5 py-1 rounded-full tracking-wider z-10">Best Seller</span>
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=400&h=500&q=80" alt="Premium Scrubs Set" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#08545e] uppercase tracking-wider">MediQo</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Classic Premium Scrubs Set</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(148 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹1,499</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#08545e] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1e40af] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#3f3f46] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 2 - Hostra --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="hostra">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=400&h=500&q=80" alt="Executive Chef Coat" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#471d23] uppercase tracking-wider">Hostra</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Executive Double-Breasted Chef Coat</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star-half text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(96 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹1,299</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-white border border-gray-300 shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1b1b1b] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 3 - Workon --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="workon">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <span class="absolute top-4 left-4 bg-blue-100 text-blue-800 text-[9px] font-extrabold uppercase px-2.5 py-1 rounded-full tracking-wider z-10">Premium</span>
                    <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=400&h=500&q=80" alt="Corporate Blazer" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#1b1b1b] uppercase tracking-wider">Workon</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Classic Fit Corporate Suit Blazer</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(212 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹2,899</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#051121] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1f2937] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 4 - Scholix --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="scholix">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1603252109303-2751441dd157?auto=format&fit=crop&w=400&h=500&q=80" alt="School Uniform set" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#0b3254] uppercase tracking-wider">Scholix</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Premium Quality School Uniform Shirt</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(340 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹499</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-white border border-gray-300 shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#93c5fd] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 5 - MediQo --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="mediqo">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&h=500&q=80" alt="Doctor Lab Coat" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#08545e] uppercase tracking-wider">MediQo</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Unisex Professional Doctor Lab Coat</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star-half text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(112 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹899</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-white border border-gray-300 shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 6 - Workon --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="workon">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?auto=format&fit=crop&w=400&h=500&q=80" alt="Polo T-Shirt" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#1b1b1b] uppercase tracking-wider">Workon</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Premium Cotton Pique Corporate Polo</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(180 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹699</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1e3a8a] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1b1b1b] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#b78a46] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 7 - Hostra --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="hostra">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=400&h=500&q=80" alt="Kitchen Apron" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#471d23] uppercase tracking-wider">Hostra</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Heavy-Duty Canvas Utility Kitchen Apron</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(64 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹399</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#78350f] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1b1b1b] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Card 8 - Scholix --}}
            <div class="product-card group bg-[#f8f9fc] rounded-2xl overflow-hidden border border-gray-200/80 hover:border-[#b78a46]/50 transition-all duration-300 flex flex-col hover-lift" data-brand="scholix">
                <div class="aspect-[4/5] bg-gray-150 relative overflow-hidden shrink-0">
                    <span class="absolute top-4 left-4 bg-emerald-100 text-emerald-800 text-[9px] font-extrabold uppercase px-2.5 py-1 rounded-full tracking-wider z-10">Best Seller</span>
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=400&h=500&q=80" alt="School Blazer/Skirt" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ url('/shop') }}" class="bg-white text-[#051121] hover:bg-[#b78a46] hover:text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-wider transition">Quick View</a>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] font-bold text-[#0b3254] uppercase tracking-wider">Scholix</span>
                    <h3 class="font-bold text-[#051121] text-sm mt-1 leading-snug flex-1">Classic Pleated School Uniform Skirt</h3>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="flex text-amber-550 gap-0.5">
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                            <i class="ph-fill ph-star text-xs text-amber-500"></i>
                        </div>
                        <span class="text-[10px] text-gray-500 font-bold">(156 reviews)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-heading font-extrabold text-[#051121] text-base">₹599</span>
                        <div class="flex gap-1">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#1e3a8a] border border-white shadow-sm"></span>
                            <span class="w-3.5 h-3.5 rounded-full bg-[#7f1d1d] border border-white shadow-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 6. SOLUTIONS / HOW TO ORDER --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-16 md:py-20 bg-[#f4f5f7]">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <div class="section-tag mb-4"><i class="ph ph-squares-four text-[10px]"></i> Our Solutions</div>
            <h2 class="font-heading font-extrabold text-2xl md:text-3xl text-[#051121] tracking-tight">Everything Your Team Needs</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-lg mx-auto">From individual purchases to large institutional orders — we handle it all.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Ready Designs --}}
            <div class="hover-lift bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="bg-[#08545e] p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-white/20 text-white text-[0.6rem] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full">D2C</span>
                        <i class="ph ph-storefront text-white/40 text-4xl"></i>
                    </div>
                    <h3 class="font-heading font-extrabold text-xl uppercase tracking-wide">Shop Ready Designs</h3>
                    <p class="text-white/70 text-xs mt-1">Wide range of ready-to-wear uniforms.</p>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <ul class="space-y-3 text-sm text-gray-600 mb-6 flex-1">
                        @foreach(['Multiple categories','Variety of colors & sizes','Easy returns & support','Fast & secure delivery'] as $f)
                        <li class="flex items-center gap-3"><i class="ph ph-check-circle text-[#08545e] text-lg shrink-0"></i> {{ $f }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/shop') }}" class="block w-full bg-[#051121] hover:bg-[#0f2340] text-white font-bold text-xs text-center uppercase tracking-widest py-3.5 rounded-lg transition">
                        Shop Now →
                    </a>
                </div>
            </div>

            {{-- Customize --}}
            <div class="hover-lift bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="bg-[#471d23] p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-white/20 text-white text-[0.6rem] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full">D2C + B2B</span>
                        <i class="ph ph-needle text-white/40 text-4xl"></i>
                    </div>
                    <h3 class="font-heading font-extrabold text-xl uppercase tracking-wide">Customize Your Brand</h3>
                    <p class="text-white/70 text-xs mt-1">Upload logo, preview on uniforms.</p>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <ul class="space-y-3 text-sm text-gray-600 mb-6 flex-1">
                        @foreach(['Upload your logo','Choose placement & colors','Embroidery & printing','Real-time preview'] as $f)
                        <li class="flex items-center gap-3"><i class="ph ph-check-circle text-[#471d23] text-lg shrink-0"></i> {{ $f }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/customize') }}" class="block w-full bg-[#471d23] hover:bg-[#5a252b] text-white font-bold text-xs text-center uppercase tracking-widest py-3.5 rounded-lg transition">
                        Customize Now →
                    </a>
                </div>
            </div>

            {{-- Bulk --}}
            <div class="hover-lift bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="bg-[#b78a46] p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-white/20 text-white text-[0.6rem] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full">B2B</span>
                        <i class="ph ph-package text-white/40 text-4xl"></i>
                    </div>
                    <h3 class="font-heading font-extrabold text-xl uppercase tracking-wide">Bulk Uniform Solutions</h3>
                    <p class="text-white/70 text-xs mt-1">For companies, hospitals & institutions.</p>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <ul class="space-y-3 text-sm text-gray-600 mb-6 flex-1">
                        @foreach(['Best bulk pricing','Dedicated account manager','On-time delivery guarantee','Quality assurance checks'] as $f)
                        <li class="flex items-center gap-3"><i class="ph ph-check-circle text-[#b78a46] text-lg shrink-0"></i> {{ $f }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/bulkorder') }}" class="block w-full bg-[#b78a46] hover:bg-[#9b7337] text-white font-bold text-xs text-center uppercase tracking-widest py-3.5 rounded-lg transition">
                        Get Bulk Quote →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 6. HOW IT WORKS --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-16 md:py-20 bg-white border-t border-gray-100">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center mb-14">
            <div class="section-tag mb-4"><i class="ph ph-steps text-[10px]"></i> Simple Process</div>
            <h2 class="font-heading font-extrabold text-3xl md:text-4xl text-[#051121] tracking-tight">How It Works</h2>
            <p class="text-gray-500 text-sm mt-2">From selection to delivery in 5 simple steps.</p>
        </div>

        <div class="relative max-w-5xl mx-auto">
            {{-- Connecting Line --}}
            <div class="hidden md:block absolute top-[54px] left-[8%] right-[8%] h-[2px] bg-gradient-to-r from-[#b78a46] via-[#051121] to-[#b78a46] opacity-35 -z-10"></div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @php
                    $steps = [
                        ['n'=>'01','icon'=>'ph-storefront',     'title'=>'Choose',      'desc'=>'Pick a product from our collections'],
                        ['n'=>'02','icon'=>'ph-pencil-line',    'title'=>'Customize',   'desc'=>'Upload logo, select colors & placement'],
                        ['n'=>'03','icon'=>'ph-monitor',        'title'=>'Preview',     'desc'=>'See how it looks on your uniform'],
                        ['n'=>'04','icon'=>'ph-file-text',      'title'=>'Order',       'desc'=>'Place order or request bulk quote'],
                        ['n'=>'05','icon'=>'ph-truck',          'title'=>'Delivery',    'desc'=>'On-time delivery at your doorstep'],
                    ];
                @endphp
                @foreach($steps as $i => $step)
                <div class="hover-lift flex flex-col items-center text-center bg-[#f4f5f7] border border-gray-200 rounded-2xl p-5 relative">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#051121] text-[#b78a46] text-xs font-bold w-9 h-9 rounded-full flex items-center justify-center tracking-widest shadow-md border border-[#b78a46]/25">{{ $step['n'] }}</div>
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mt-3 mb-4 shadow-sm border border-gray-200">
                        <i class="ph {{ $step['icon'] }} text-[#b78a46] text-2xl"></i>
                    </div>
                    <h4 class="font-heading font-extrabold text-sm uppercase tracking-wider text-[#051121] mb-2">{{ $step['title'] }}</h4>
                    <p class="text-[11px] text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Feature chips row --}}
        <div class="flex flex-wrap justify-center gap-4 mt-12">
            @php
                $chips = ['Easy Ordering','Secure Payment','Quality Promise','Easy Returns','Dedicated Support','PAN India Delivery'];
            @endphp
            @foreach($chips as $chip)
            <div class="flex items-center gap-2 bg-[#f4f5f7] border border-gray-200 rounded-full px-5 py-2.5 text-[10px] font-extrabold uppercase tracking-widest text-gray-600">
                <i class="ph ph-check text-[#b78a46]"></i> {{ $chip }}
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 7. TESTIMONIALS --}}
{{-- ════════════════════════════════════════ --}}
<section class="py-16 md:py-20 bg-[#f4f5f7] border-t border-gray-200">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <div class="section-tag mb-4"><i class="ph ph-quotes text-[10px]"></i> Client Stories</div>
            <h2 class="font-heading font-extrabold text-3xl md:text-4xl text-[#051121] tracking-tight">What Our Clients Say</h2>
            <p class="text-gray-500 text-sm mt-2">Trusted by hospitals, hotels, schools, and corporations across India.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $testimonials = [
                    [
                        'name'    => 'Dr. Priya Suresh',
                        'role'    => 'Head of Nursing, Apollo Hospitals',
                        'brand'   => 'MediQo',
                        'color'   => 'bg-[#08545e]',
                        'avatar'  => 'https://images.unsplash.com/photo-1594824813573-246434de83fb?auto=format&fit=crop&w=100&h=100&q=80',
                        'quote'   => 'The scrubs and lab coats from FM Uniforms are outstanding. Fabric quality is excellent and the embroidery on our hospital name looks incredibly professional. Bulk delivery was on time.',
                        'rating'  => 5,
                    ],
                    [
                        'name'    => 'Rajiv Menon',
                        'role'    => 'GM Operations, The Leela Palace',
                        'brand'   => 'Hostra',
                        'color'   => 'bg-[#471d23]',
                        'avatar'  => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&h=100&q=80',
                        'quote'   => 'We\'ve been ordering chef coats and service staff uniforms for 3 years now. FM Uniforms consistently delivers premium quality with perfect stitching and great color retention after washing.',
                        'rating'  => 5,
                    ],
                    [
                        'name'    => 'Kavitha Rajan',
                        'role'    => 'HR Director, Infosys Campus',
                        'brand'   => 'Workon',
                        'color'   => 'bg-[#1b1b1b]',
                        'avatar'  => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&h=100&q=80',
                        'quote'   => 'Our entire 200-person team received customized polo shirts within 12 days. The logo embroidery is sharp and the comfort level is superb. Will definitely reorder every quarter.',
                        'rating'  => 5,
                    ],
                ];
            @endphp
            @foreach($testimonials as $t)
            <div class="hover-lift bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
                <div class="{{ $t['color'] }} px-6 py-4 flex items-center justify-between">
                    <span class="text-[0.6rem] text-white font-extrabold uppercase tracking-[0.2em]">{{ $t['brand'] }}</span>
                    <div class="flex gap-0.5">
                        @for($i = 0; $i < $t['rating']; $i++)
                        <i class="ph ph-star-fill star-fill text-sm"></i>
                        @endfor
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <i class="ph ph-quotes text-[#b78a46] text-3xl mb-3"></i>
                    <p class="text-sm text-gray-600 leading-relaxed flex-1 italic">"{{ $t['quote'] }}"</p>
                    <div class="mt-5 pt-5 border-t border-gray-100 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full overflow-hidden shrink-0 border-2 border-gray-150 shadow-sm">
                            <img src="{{ $t['avatar'] }}" alt="{{ $t['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-bold text-sm text-[#051121]">{{ $t['name'] }}</div>
                            <div class="text-[11px] text-gray-400">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════ --}}
{{-- 8. B2B CTA BANNER --}}
{{-- ════════════════════════════════════════ --}}
<section class="bg-[#051121] text-white py-16 px-4 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: repeating-linear-gradient(45deg, #b78a46 0, #b78a46 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
    <div class="max-w-[1200px] mx-auto text-center relative z-10">
        <div class="section-tag mb-6 mx-auto" style="background: rgba(183,138,70,0.15); border-color: rgba(183,138,70,0.3); color: #b78a46;">
            <i class="ph ph-lightning text-[10px]"></i> B2B Bulk Orders
        </div>
        <h2 class="font-heading font-extrabold text-3xl md:text-5xl tracking-tight mb-4">
            Need Uniforms for Your<br><span class="text-[#b78a46]">Entire Team?</span>
        </h2>
        <p class="text-gray-400 text-base max-w-2xl mx-auto mb-10">
            Hospitals, hotels, corporates and schools — we handle bulk orders of any size with custom branding, dedicated support, and guaranteed on-time delivery.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/bulkorder') }}" class="bg-[#b78a46] hover:bg-[#9b7337] text-white font-extrabold text-sm uppercase tracking-widest px-10 py-4 rounded-sm transition-all shadow-2xl shadow-[#b78a46]/20 flex items-center gap-3">
                <i class="ph ph-package-plus text-xl"></i> Request Bulk Quote
            </a>
            <a href="tel:+919994969811" class="border border-white/30 hover:border-white text-white font-bold text-sm uppercase tracking-widest px-8 py-4 rounded-sm transition-all flex items-center gap-3">
                <i class="ph ph-phone text-xl"></i> +91 99949 69811
            </a>
        </div>
        <div class="flex flex-wrap justify-center gap-8 mt-12 text-xs text-gray-400 font-bold uppercase tracking-widest">
            <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#b78a46] text-sm shrink-0"></i> No Minimum Order</span>
            <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#b78a46] text-sm shrink-0"></i> Custom Logo &amp; Embroidery</span>
            <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#b78a46] text-sm shrink-0"></i> Dedicated Account Manager</span>
            <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#b78a46] text-sm shrink-0"></i> GST Invoice Provided</span>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════ --}}
{{-- 10. BLOG TEASER --}}
{{-- ════════════════════════════════════════ --}}
@if(isset($latestBlogs) && $latestBlogs->count() > 0)
<section class="py-16 md:py-20 bg-[#f4f5f7] border-t border-gray-200">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <div class="section-tag mb-3"><i class="ph ph-newspaper text-[10px]"></i> Journal</div>
                <h2 class="font-heading font-extrabold text-3xl md:text-4xl text-[#051121] tracking-tight">Latest from the Blog</h2>
            </div>
            <a href="{{ url('/blog') }}" class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#051121] hover:text-[#b78a46] transition-colors">
                View All Posts <i class="ph ph-arrow-right"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestBlogs as $blog)
            <a href="{{ url('/blog/' . $blog->slug) }}" class="hover-lift bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex flex-col group">
                <div class="aspect-[16/9] overflow-hidden">
                    <img src="{{ $blog->image ? env('MAIN_URL').'images/blogs/'.$blog->image : 'https://placehold.co/640x360/051121/b78a46?text=FM+Uniforms' }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[0.6rem] text-[#b78a46] font-bold uppercase tracking-widest mb-2">{{ $blog->created_at->format('d M Y') }}</span>
                    <h3 class="font-heading font-bold text-sm text-[#051121] leading-snug line-clamp-2 flex-1 group-hover:text-[#b78a46] transition-colors">{{ $blog->title }}</h3>
                    <div class="mt-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 flex items-center gap-1 group-hover:text-[#b78a46] transition-colors">
                        Read Article <i class="ph ph-arrow-right"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8 md:hidden">
            <a href="{{ url('/blog') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#051121] hover:text-[#b78a46] transition-colors">
                View All Posts <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════ --}}
{{-- 11. NEWSLETTER / CONTACT STRIP --}}
{{-- ════════════════════════════════════════ --}}
<section class="bg-[#0b1c30] text-white border-t border-gray-800 py-14 px-4">
    <div class="max-w-[900px] mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <div>
            <h3 class="font-heading font-extrabold text-xl text-white mb-1">Stay in the Loop</h3>
            <p class="text-sm text-gray-400">Get uniform tips, new collection alerts and exclusive B2B offers.</p>
        </div>
        <form class="flex w-full md:w-auto gap-0 min-w-[340px] shadow-lg" onsubmit="return false;">
            <input type="email" placeholder="Enter your work email" class="flex-1 text-sm px-5 py-3.5 border-none rounded-l-sm focus:outline-none bg-white/10 text-white placeholder-gray-400">
            <button class="bg-[#b78a46] hover:bg-[#9b7337] text-white font-bold text-xs uppercase tracking-widest px-6 py-3.5 rounded-r-sm transition-colors whitespace-nowrap">
                Subscribe
            </button>
        </form>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Animate stat counters when they scroll into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('fade-up');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.2 });
    document.querySelectorAll('.hover-lift').forEach(el => observer.observe(el));

    // Filter featured products
    const prodFilterBtns = document.querySelectorAll('.product-filter-btn');
    const prodCards = document.querySelectorAll('.product-card');

    prodFilterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const filter = this.dataset.filter;

            // Update active state
            prodFilterBtns.forEach(b => {
                b.classList.remove('active', 'bg-[#051121]', 'text-white');
                b.classList.add('border-gray-200', 'text-gray-600');
            });
            this.classList.add('active', 'bg-[#051121]', 'text-white');
            this.classList.remove('border-gray-200', 'text-gray-600');

            // Filter cards
            prodCards.forEach(card => {
                if (filter === 'all' || card.dataset.brand === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
