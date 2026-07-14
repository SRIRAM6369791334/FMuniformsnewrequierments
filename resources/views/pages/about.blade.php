@extends('layouts.app')

@section('content')

{{-- Tailwind CDN (preflight disabled — protects Bootstrap header/footer) --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<script>
    tailwind.config = {
        corePlugins: { preflight: false },
        theme: {
            extend: {
                fontFamily: {
                    sans:    ['Inter', 'sans-serif'],
                    heading: ['Montserrat', 'sans-serif'],
                }
            }
        }
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('about-theme/css/index.css') }}">
<link rel="stylesheet" href="{{ asset('about-theme/css/responsive.css') }}">

{{-- All About Page content scoped under .abpg-wrap to isolate from Bootstrap --}}
<div class="abpg-wrap" style="font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b;">

    {{-- ================================================================= --}}
    {{-- S1 · MERGED HERO — Headline + Story + Images                      --}}
    {{-- ================================================================= --}}
    <section style="position:relative; overflow:hidden; background: linear-gradient(135deg, #090d16 0%, #0f172a 55%, #1e293b 100%); padding: 140px 0 80px;">
        {{-- Gold top accent --}}
        <div style="position:absolute; top:0; left:0; right:0; height:3px; background: linear-gradient(90deg, #c99355, #e2b683, #c99355);"></div>
        {{-- Ambient glow orbs --}}
        <div style="position:absolute; top:-120px; right:-100px; width:500px; height:500px; border-radius:50%; background: radial-gradient(circle, rgba(201,147,85,0.08) 0%, transparent 70%); pointer-events:none;"></div>
        <div style="position:absolute; bottom:-100px; left:-100px; width:380px; height:380px; border-radius:50%; background: radial-gradient(circle, rgba(201,147,85,0.05) 0%, transparent 70%); pointer-events:none;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="position:relative; z-index:1;">
            <div class="flex flex-col lg:flex-row gap-14 lg:gap-20 items-center">

                {{-- LEFT: All Text Content --}}
                <div class="w-full lg:w-1/2" style="padding-right: clamp(0px, 4vw, 48px);">

                    {{-- Breadcrumb --}}
                    <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:#64748b; margin-bottom:28px;">
                        <a href="{{ url('/') }}" style="color:#64748b; text-decoration:none;">Home</a>
                        <i class="ph ph-caret-right" style="font-size:10px;"></i>
                        <span style="color:#c99355; font-weight:600;">About Us</span>
                    </div>

                    {{-- Label pill --}}
                    <div class="abpg-label" style="margin-bottom:24px;">
                        <i class="ph ph-sparkle"></i>
                        About FM Uniforms
                    </div>

                    {{-- Main headline --}}
                    <h1 style="font-family:'Montserrat',sans-serif; font-size:clamp(1.6rem,3vw,2.4rem); font-weight:900; color:#ffffff; line-height:1.22; letter-spacing:-0.02em; margin-bottom:24px;">
                        Organizing the Unorganized<br>
                        <span style="background: linear-gradient(90deg,#c99355,#e2b683,#c99355); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Uniform Sector.</span>
                    </h1>

                    {{-- Gold accent rule + subheading side by side --}}
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:28px;">
                        <div style="width:36px; height:3px; background:linear-gradient(90deg,#c99355,#e2b683); border-radius:3px; flex-shrink:0;"></div>
                        <p style="font-family:'Montserrat',sans-serif; font-size:0.9rem; font-weight:700; color:#c99355; margin:0; letter-spacing:0.02em;">
                            15+ Years of Excellence in Uniform Manufacturing
                        </p>
                    </div>

                    {{-- Description --}}
                    <p style="font-size:14px; color:#94a3b8; line-height:1.9; margin-bottom:48px; max-width:520px;">
                        Founded with a vision to organize the fragmented uniform sector, FM Uniforms has grown from a small custom tailoring unit into a trusted bulk manufacturing partner for leading institutions across India — controlling every step from fabric sourcing to final quality control, all under one ISO 9001 certified roof.
                    </p>

                    {{-- Four Pillars --}}
                    <div style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:16px; padding:24px; margin-bottom:36px; backdrop-filter:blur(8px);">
                        <div style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.10em; color:#94a3b8; margin-bottom:16px;">Our Four Pillars of Expertise</div>
                        <div class="grid grid-cols-2 gap-3">
                            @php
                            $pillars = [
                                ['ph-heartbeat','rgba(201,147,85,0.12)','#c99355','FM Mediqo','Healthcare Apparel','/collections/mediqo'],
                                ['ph-cooking-pot','rgba(201,147,85,0.12)','#c99355','FM Hostra','Hospitality Wear','/collections/hostra'],
                                ['ph-briefcase','rgba(201,147,85,0.12)','#c99355','FM Workon','Corporate Uniforms','/collections/workon'],
                                ['ph-backpack','rgba(201,147,85,0.12)','#c99355','FM Scholix','School & Gear','/collections/scholix'],
                            ];
                            @endphp
                            @foreach($pillars as $p)
                            <a href="{{ url($p[5]) }}" style="display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:10px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.07); text-decoration:none; transition:border-color 0.2s;" onmouseover="this.style.borderColor='rgba(201,147,85,0.40)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'">
                                <div style="width:34px; height:34px; border-radius:8px; background:{{ $p[1] }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="ph {{ $p[0] }}" style="color:{{ $p[2] }}; font-size:1rem;"></i>
                                </div>
                                <div>
                                    <div style="font-family:'Montserrat',sans-serif; font-size:12px; font-weight:700; color:#ffffff;">{{ $p[3] }}</div>
                                    <div style="font-size:11px; color:#64748b; margin-top:2px;">{{ $p[4] }}</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap gap-4" style="margin-bottom:36px;">
                        <a href="{{ url('/shop') }}" style="display:inline-flex; align-items:center; gap:8px; background: linear-gradient(90deg,#c99355,#e2b683); color:#0f172a; font-family:'Montserrat',sans-serif; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.10em; padding:15px 28px; border-radius:10px; transition:all 0.3s; box-shadow:0 8px 24px rgba(201,147,85,0.30); text-decoration:none;">
                            Explore Collections <i class="ph ph-arrow-right"></i>
                        </a>
                        <a href="{{ url('/bulkorder') }}" style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.14); color:#ffffff; font-family:'Montserrat',sans-serif; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.10em; padding:15px 28px; border-radius:10px; transition:all 0.3s; text-decoration:none; backdrop-filter:blur(8px);">
                            Get Bulk Quote
                        </a>
                    </div>

                    {{-- Stats Row --}}
                    <div class="grid grid-cols-4 gap-3" style="margin-bottom:0;">
                        @foreach([['15+','Years Exp.'],['500+','B2B Clients'],['1M+','Garments'],['100%','In-House']] as $stat)
                        <div style="text-align:center; padding:14px 8px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:12px;">
                            <div style="font-family:'Montserrat',sans-serif; font-size:clamp(1.1rem,2vw,1.5rem); font-weight:900; color:#ffffff; line-height:1;">{{ $stat[0] }}</div>
                            <div style="font-family:'Montserrat',sans-serif; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:0.10em; color:#c99355; margin-top:4px;">{{ $stat[1] }}</div>
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- RIGHT: Image Mosaic --}}
                <div class="w-full lg:w-1/2" style="position:relative;">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="/media/images/portfolio/hospital_uniforms.png" alt="FM Hospital Wear"
                             class="w-full object-cover rounded-2xl"
                             style="height:240px; margin-top:48px; transition:transform 0.3s; box-shadow:0 20px 48px rgba(0,0,0,0.35);"
                             onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        <img src="/media/images/portfolio/school_uniforms.png" alt="FM School Uniforms"
                             class="w-full object-cover rounded-2xl"
                             style="height:240px; transition:transform 0.3s; box-shadow:0 20px 48px rgba(0,0,0,0.35);"
                             onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        <img src="/media/images/portfolio/corporate_uniforms.png" alt="FM Corporate Wear"
                             class="w-full object-cover rounded-2xl col-span-2"
                             style="height:150px; transition:transform 0.3s; box-shadow:0 20px 48px rgba(0,0,0,0.35);"
                             onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                    {{-- ISO Quality Stamp --}}
                    <div style="position:absolute; top:46%; left:50%; transform:translate(-50%,-50%); background:rgba(15,23,42,0.90); padding:14px; border-radius:50%; box-shadow:0 16px 48px rgba(0,0,0,0.5); z-index:10; border:1px solid rgba(201,147,85,0.30); backdrop-filter:blur(8px);">
                        <div style="width:72px; height:72px; border:2px dashed #c99355; border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                            <i class="ph-fill ph-seal-check" style="color:#c99355; font-size:1.8rem; margin-bottom:2px;"></i>
                            <span style="font-size:8px; font-family:'Montserrat',sans-serif; font-weight:800; text-transform:uppercase; letter-spacing:0.06em; color:#e2b683; text-align:center; line-height:1.2;">ISO 9001<br>Certified</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- S2.5 · OUR JOURNEY — MILESTONE TIMELINE                           --}}
    {{-- ================================================================= --}}
    <section style="background:#f1f5f9; padding: 80px 0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div style="text-align:center; margin-bottom:48px;">
                <div class="abpg-divider" style="justify-content:center;">
                    <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; color:#c99355;">Our History</span>
                </div>
                <h2 style="font-family:'Montserrat',sans-serif; font-size:clamp(1.5rem,3vw,2rem); font-weight:900; color:#0f172a; letter-spacing:-0.01em;">
                    From One Tailoring Unit to a <span style="color:#c99355;">National Partner</span>
                </h2>
            </div>

            {{-- Timeline --}}
            <div style="position:relative;" class="pl-8 sm:pl-0">
                {{-- Vertical spine --}}
                <div class="absolute left-4 sm:left-1/2 top-2 bottom-2 w-[2px] -translate-x-1/2" style="background: linear-gradient(to bottom, #c99355, #cbd5e1);"></div>

                @php
                $milestones = [
                    ['2010','Founded in a Single Room','FM Uniforms began as a small custom-tailoring unit taking on local school and hospital orders by hand.','ph-storefront'],
                    ['2014','First Bulk Institutional Order','Crossed our first 1,000-piece order for a regional hospital network, prompting our move to dedicated production floors.','ph-package'],
                    ['2017','In-House Embroidery & Printing','Brought embroidery, digital printing, and finishing under one roof to control quality and turnaround end to end.','ph-needle'],
                    ['2020','ISO 9001 Certification','Formalised our quality management system and earned ISO 9001 certification across all production units.','ph-seal-check'],
                    ['2023','500+ B2B Clients Nationwide','Reached 500+ active institutional clients spanning healthcare, hospitality, education, and corporate sectors.','ph-buildings'],
                    ['Today','1M+ Garments and Counting','Pan-India delivery, four dedicated sub-brands, and a supply chain built entirely in-house.','ph-truck'],
                ];
                @endphp

                <div class="abpg-timeline-items space-y-10">
                    @foreach($milestones as $index => $m)
                    <div style="position:relative;" class="flex flex-col sm:flex-row items-start sm:items-center justify-between {{ $index % 2 === 0 ? '' : 'sm:flex-row-reverse' }}">

                        {{-- Spacer (desktop only) --}}
                        <div class="hidden sm:block" style="width:45%;"></div>

                        {{-- Bullet --}}
                        <div class="absolute left-4 sm:left-1/2 top-1.5 sm:top-1/2 -translate-x-1/2 sm:-translate-y-1/2 w-8 h-8 rounded-full bg-[#0f172a] border-2 border-[#c99355] flex items-center justify-center z-10 shadow-lg">
                            <i class="ph {{ $m[3] }}" style="color:#c99355; font-size:13px;"></i>
                        </div>

                        {{-- Card --}}
                        <div class="abpg-milestone-card w-full sm:w-5/12">
                            <div style="display:flex; align-items:center; flex-wrap:wrap; gap:6px; margin-bottom:6px;">
                                <span class="abpg-milestone-year">{{ $m[0] }}</span>
                                <span class="abpg-milestone-title">{{ $m[1] }}</span>
                            </div>
                            <p class="abpg-milestone-desc">{{ $m[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- S3 · FEATURE STRIP                                                --}}
    {{-- ================================================================= --}}
    <section style="background:#ffffff; padding: 48px 0; border-top:1px solid #e2e8f0; border-bottom:1px solid #e2e8f0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                $features = [
                    ['ph-truck','FREE SHIPPING','Free shipping on all orders','#dbeafe','#1d4ed8'],
                    ['ph-headset','ONLINE SUPPORT','24/7 customer support','#dcfce7','#15803d'],
                    ['ph-arrow-counter-clockwise','MONEY RETURN','Back guarantee under 5 days','#fef9c3','#92400e'],
                    ['ph-tag','MEMBER DISCOUNT','On every order over ₹5,000','#fce7f3','#9d174d'],
                ];
                @endphp
                @foreach($features as $f)
                <div class="abpg-feature-card">
                    <div class="abpg-feature-icon" style="background:{{ $f[3] }}; color:{{ $f[4] }};">
                        <i class="ph {{ $f[0] }}"></i>
                    </div>
                    <div>
                        <div class="abpg-feature-title">{{ $f[1] }}</div>
                        <div class="abpg-feature-sub">{{ $f[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- S4 · HOW WE WORK PROCESS STEPS                                    --}}
    {{-- ================================================================= --}}
    <section style="background:#ffffff; padding: 80px 0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div style="text-align:center; margin-bottom:48px;">
                <div class="abpg-divider" style="justify-content:center;">
                    <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; color:#c99355;">Process</span>
                </div>
                <h2 style="font-family:'Montserrat',sans-serif; font-size:clamp(1.5rem,3vw,2rem); font-weight:900; color:#0f172a; letter-spacing:-0.01em;">
                    How We <span style="color:#c99355;">Work</span>
                </h2>
            </div>

            <div class="abpg-steps-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                @php
                $steps = [
                    ['1','ph-crosshair','CHOOSE','Pick from our wide catalogue of ready designs.'],
                    ['2','ph-pencil-simple','CUSTOMIZE','Upload logo, pick colors & embroidery placement.'],
                    ['3','ph-monitor','PREVIEW','See your branded uniform before production.'],
                    ['4','ph-file-text','ORDER','Place order or submit a bulk quote request.'],
                    ['5','ph-truck','DELIVERY','On-time PAN India delivery at your doorstep.'],
                ];
                @endphp
                @foreach($steps as $s)
                <div class="abpg-step-card">
                    <div class="abpg-step-icon">
                        <i class="ph {{ $s[1] }}"></i>
                    </div>
                    <span class="abpg-step-num">Step {{ $s[0] }}</span>
                    <div class="abpg-step-title">{{ $s[2] }}</div>
                    <p class="abpg-step-desc">{{ $s[3] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- S5 · DARK FEATURES BANNER                                         --}}
    {{-- ================================================================= --}}
    <section style="background:#0f172a; border-top:1px solid #1e293b; border-bottom:1px solid #1e293b;">
        <div style="max-width:80rem; margin:0 auto;">
            <div class="abpg-dark-grid">
                @php
                $darkFeats = [
                    ['ph-medal','PREMIUM FABRICS','Carefully selected for durability, comfort and professional finish.'],
                    ['ph-pencil-ruler','PERFECT FIT','Sized and tailored to fit every team member uniformly.'],
                    ['ph-seal-check','QUALITY ASSURED','Rigorous quality checks on every single garment.'],
                    ['ph-truck','ON-TIME DELIVERY','Pan India delivery with real-time tracking.'],
                    ['ph-headset','DEDICATED SUPPORT','Dedicated relationship manager for every B2B order.'],
                ];
                @endphp
                @foreach($darkFeats as $df)
                <div class="abpg-dark-feat">
                    <i class="ph {{ $df[0] }} abpg-dark-feat-icon"></i>
                    <div class="abpg-dark-feat-title">{{ $df[1] }}</div>
                    <p class="abpg-dark-feat-desc">{{ $df[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- S5.5 · CERTIFICATIONS & COMPLIANCE                                --}}
    {{-- ================================================================= --}}
    <section style="background:#ffffff; padding: 80px 0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12 items-center">

                {{-- Left: text --}}
                <div class="w-full lg:w-5/12">
                    <div class="abpg-divider">
                        <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; color:#c99355;">Compliance</span>
                    </div>
                    <h2 style="font-family:'Montserrat',sans-serif; font-size:clamp(1.6rem,3.5vw,2.2rem); font-weight:900; color:#0f172a; line-height:1.25; margin-bottom:16px; letter-spacing:-0.01em;">
                        Certified & Compliant<br>at Every Stage.
                    </h2>
                    <p style="font-size:14px; color:#64748b; line-height:1.75;">
                        Every unit that touches your order — sourcing, stitching, embroidery, and packaging — operates under documented quality checks so institutional buyers can procure with confidence.
                    </p>
                </div>

                {{-- Right: cert cards --}}
                <div class="w-full lg:w-7/12">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @php
                        $certs = [
                            ['ph-seal-check','ISO 9001:2015','Quality Management'],
                            ['ph-leaf','OEKO-TEX Fabrics','Tested Inputs'],
                            ['ph-shield-check','GST Registered','Verified B2B Entity'],
                            ['ph-recycle','Eco Cutting','Low Fabric Waste'],
                        ];
                        @endphp
                        @foreach($certs as $c)
                        <div class="abpg-cert-card">
                            <div class="abpg-cert-icon">
                                <i class="ph {{ $c[0] }}"></i>
                            </div>
                            <div class="abpg-cert-name">{{ $c[1] }}</div>
                            <div class="abpg-cert-sub">{{ $c[2] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- S6 · OUR HAPPY CLIENTS                                            --}}
    {{-- ================================================================= --}}
    <section style="position:relative; overflow:hidden; padding: 80px 0; background: linear-gradient(180deg, #0f172a 0%, #090d16 100%);">
        {{-- Dot pattern --}}
        <div style="position:absolute; inset:0; pointer-events:none; opacity:0.40; background-image: radial-gradient(circle, rgba(201,147,85,0.08) 1px, transparent 1px); background-size:24px 24px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="position:relative; z-index:1;">

            {{-- Header --}}
            <div style="text-align:center; margin-bottom:56px;">
                <div class="abpg-divider" style="justify-content:center;">
                    <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; color:#c99355;">Trusted By Industry Leaders</span>
                </div>
                <h2 style="font-family:'Montserrat',sans-serif; font-size:clamp(1.6rem,3.5vw,2.4rem); font-weight:900; color:#ffffff; letter-spacing:-0.01em; margin-bottom:12px;">
                    Our Happy <span style="color:#c99355;">Clients</span>
                </h2>
                <p style="font-size:14px; color:#94a3b8; line-height:1.75; max-width:480px; margin:0 auto;">
                    From top-tier medical networks and luxury hotels to premier schools and industrial conglomerates.
                </p>
            </div>

            {{-- Carousel Row 1: Healthcare & Academic --}}
            <div style="margin-bottom:36px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.10em; color:#475569; white-space:nowrap;">Healthcare & Academic</span>
                    <div style="flex-grow:1; height:1px; background:#1e293b;"></div>
                </div>
                <div style="overflow:hidden; border-radius:16px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.04); padding:20px 0;">
                    <div class="abpg-carousel-track scroll-left">
                        @for ($i = 1; $i <= 6; $i++)
                        <div class="abpg-logo-card">
                            <img src="/media/images/logo/ab{{ $i }}.jpg" alt="Client Logo {{ $i }}">
                        </div>
                        @endfor
                        {{-- Seamless duplicate --}}
                        @for ($i = 1; $i <= 6; $i++)
                        <div class="abpg-logo-card">
                            <img src="/media/images/logo/ab{{ $i }}.jpg" alt="Client Logo {{ $i }}">
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Carousel Row 2: Corporate & Industrial (reverse) --}}
            <div style="margin-bottom:48px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="flex-grow:1; height:1px; background:#1e293b;"></div>
                    <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.10em; color:#475569; white-space:nowrap;">Corporate & Industrial Partners</span>
                </div>
                <div style="overflow:hidden; border-radius:16px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.04); padding:20px 0;">
                    <div class="abpg-carousel-track scroll-right">
                        @for ($i = 7; $i <= 12; $i++)
                        <div class="abpg-logo-card">
                            <img src="/media/images/logo/ab{{ $i }}.jpg" alt="Client Logo {{ $i }}">
                        </div>
                        @endfor
                        {{-- Seamless duplicate --}}
                        @for ($i = 7; $i <= 12; $i++)
                        <div class="abpg-logo-card">
                            <img src="/media/images/logo/ab{{ $i }}.jpg" alt="Client Logo {{ $i }}">
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Trust / Rating bar --}}
            <div style="display:flex; justify-content:center; margin-bottom:56px;">
                <div style="display:inline-flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:16px; background:rgba(255,255,255,0.05); border:1px solid rgba(251,191,36,0.20); border-radius:999px; padding:12px 28px; backdrop-filter:blur(10px);">
                    <div style="display:flex; align-items:center; gap:4px;">
                        @for($j = 0; $j < 5; $j++)
                        <i class="ph-fill ph-star" style="color:#fbbf24; font-size:1.1rem;"></i>
                        @endfor
                        <span style="font-family:'Montserrat',sans-serif; font-size:14px; font-weight:800; color:#ffffff; margin-left:8px;">4.9 / 5</span>
                    </div>
                    <div style="width:1px; height:20px; background:rgba(255,255,255,0.10);" class="hidden sm:block"></div>
                    <div style="font-size:12px; color:#94a3b8;">
                        Trusted by <span style="color:#ffffff; font-weight:700;">500+</span> top organizations nationwide.
                    </div>
                </div>
            </div>

            {{-- S6.5 Testimonials --}}
            <div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:28px;">
                    <span style="font-family:'Montserrat',sans-serif; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.10em; color:#475569; white-space:nowrap;">In Their Words</span>
                    <div style="flex-grow:1; height:1px; background:#1e293b;"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @php
                    $testimonials = [
                        ['FM Uniforms restitched our entire nursing and housekeeping wardrobe inside a single billing cycle, with zero size-chart errors across 40 departments.', 'Procurement Head', 'Multi-Speciality Hospital Group'],
                        ['We switched from three separate vendors to one. Embroidery, fabric, and delivery dates finally line up the way they should.', 'Front Office Director', 'Boutique Hotel Chain'],
                        ['Reordering blazers mid-year for new admissions used to take weeks. It now takes a phone call.', 'Administrative Officer', 'CBSE School Network'],
                    ];
                    @endphp
                    @foreach($testimonials as $t)
                    <div class="abpg-testimonial">
                        <div>
                            <i class="ph-fill ph-quotes" style="color:#c99355; font-size:1.5rem; opacity:0.70; margin-bottom:12px; display:block;"></i>
                            <p class="abpg-testimonial-text">"{{ $t[0] }}"</p>
                        </div>
                        <div style="display:flex; align-items:center; gap:12px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.08);">
                            <div style="width:36px; height:36px; border-radius:50%; background:rgba(201,147,85,0.12); border:1px solid rgba(201,147,85,0.28); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="ph ph-user" style="color:#c99355; font-size:1rem;"></i>
                            </div>
                            <div>
                                <div class="abpg-testimonial-name">{{ $t[1] }}</div>
                                <div class="abpg-testimonial-org">{{ $t[2] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

</div>
@endsection