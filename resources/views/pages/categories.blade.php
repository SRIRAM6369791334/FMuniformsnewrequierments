@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-brand-mediqo">Home</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i> 
        <span class="text-gray-800 font-medium">MediQo</span>
    </div>

    <!-- Shop by Category -->
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-20">
        <!-- Section Header -->
        <div class="mb-10 flex items-center justify-center gap-4">
            <div class="h-px bg-gray-300 w-full max-w-[100px] md:max-w-[200px]"></div>
            <i class="ph ph-activity text-brand-mediqo text-xl"></i>
            <h2 class="font-heading font-bold text-xl text-brand-navy uppercase tracking-widest whitespace-nowrap">SHOP BY CATEGORY</h2>
            <i class="ph ph-activity text-brand-mediqo text-xl"></i>
            <div class="h-px bg-gray-300 w-full max-w-[100px] md:max-w-[200px]"></div>
        </div>

        <!-- 3x2 Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Category 1: Scrubs -->
            <a href="{{ url('/shop') }}" class="category-card group bg-blue-50 border border-blue-100 rounded-xl overflow-hidden block">
                <div class="h-56 w-full flex items-center justify-center pt-8 px-4 overflow-hidden bg-gradient-to-b from-blue-50 to-blue-100/50">
                    <img src="https://placehold.co/500x400/94a3b8/e2e8f0?text=Teal+Scrubs" alt="Scrubs" class="h-full object-contain mix-blend-multiply object-bottom transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 bg-white relative">
                    <div class="w-12 h-12 bg-brand-mediqo text-white rounded-full flex items-center justify-center absolute -top-6 left-8 shadow-lg">
                        <i class="ph ph-shirt-folded text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-brand-navy mb-2 mt-4">SCRUBS</h3>
                    <p class="text-sm text-gray-600 mb-6">Comfortable. Functional.<br>Built for long shifts.</p>
                    <span class="text-brand-mediqo font-bold text-xs uppercase tracking-widest group-hover:underline">EXPLORE <i class="ph ph-arrow-right ml-1"></i></span>
                </div>
            </a>

            <!-- Category 2: Lab Coats -->
            <a href="{{ url('/shop') }}" class="category-card group bg-gray-50 border border-gray-100 rounded-xl overflow-hidden block">
                <div class="h-56 w-full flex items-center justify-center pt-8 px-4 overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100/50">
                    <img src="https://placehold.co/500x400/94a3b8/e2e8f0?text=Lab+Coats" alt="Lab Coats" class="h-full object-contain mix-blend-multiply object-bottom transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 bg-white relative">
                    <div class="w-12 h-12 bg-brand-mediqo text-white rounded-full flex items-center justify-center absolute -top-6 left-8 shadow-lg">
                        <i class="ph ph-coat text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-brand-navy mb-2 mt-4">LAB COATS</h3>
                    <p class="text-sm text-gray-600 mb-6">Professional look.<br>Trusted protection.</p>
                    <span class="text-brand-mediqo font-bold text-xs uppercase tracking-widest group-hover:underline">EXPLORE <i class="ph ph-arrow-right ml-1"></i></span>
                </div>
            </a>

            <!-- Category 3: OT Wear -->
            <a href="{{ url('/shop') }}" class="category-card group bg-indigo-50 border border-indigo-100 rounded-xl overflow-hidden block">
                <div class="h-56 w-full flex items-center justify-center pt-8 px-4 overflow-hidden bg-gradient-to-b from-indigo-50 to-indigo-100/50">
                    <img src="https://placehold.co/500x400/94a3b8/e2e8f0?text=OT+Wear" alt="OT Wear" class="h-full object-contain mix-blend-multiply object-bottom transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 bg-white relative">
                    <div class="w-12 h-12 bg-brand-mediqo text-white rounded-full flex items-center justify-center absolute -top-6 left-8 shadow-lg">
                        <i class="ph ph-mask-happy text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-brand-navy mb-2 mt-4">OT WEAR</h3>
                    <p class="text-sm text-gray-600 mb-6">Sterile. Reliable.<br>Built for critical care.</p>
                    <span class="text-brand-mediqo font-bold text-xs uppercase tracking-widest group-hover:underline">EXPLORE <i class="ph ph-arrow-right ml-1"></i></span>
                </div>
            </a>

            <!-- Category 4: Nurse Wear -->
            <a href="{{ url('/shop') }}" class="category-card group bg-teal-50 border border-teal-100 rounded-xl overflow-hidden block">
                <div class="h-56 w-full flex items-center justify-center pt-8 px-4 overflow-hidden bg-gradient-to-b from-teal-50 to-teal-100/50">
                    <img src="https://placehold.co/500x400/94a3b8/e2e8f0?text=Nurse+Wear" alt="Nurse Wear" class="h-full object-contain mix-blend-multiply object-bottom transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 bg-white relative">
                    <div class="w-12 h-12 bg-brand-mediqo text-white rounded-full flex items-center justify-center absolute -top-6 left-8 shadow-lg">
                        <i class="ph ph-first-aid text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-brand-navy mb-2 mt-4">NURSE WEAR</h3>
                    <p class="text-sm text-gray-600 mb-6">Designed for movement.<br>Made for comfort.</p>
                    <span class="text-brand-mediqo font-bold text-xs uppercase tracking-widest group-hover:underline">EXPLORE <i class="ph ph-arrow-right ml-1"></i></span>
                </div>
            </a>

            <!-- Category 5: Patient Wear -->
            <a href="{{ url('/shop') }}" class="category-card group bg-blue-50/50 border border-blue-100 rounded-xl overflow-hidden block">
                <div class="h-56 w-full flex items-center justify-center pt-8 px-4 overflow-hidden bg-gradient-to-b from-blue-50/50 to-blue-100/30">
                    <img src="https://placehold.co/500x400/94a3b8/e2e8f0?text=Patient+Wear" alt="Patient Wear" class="h-full object-contain mix-blend-multiply object-bottom transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 bg-white relative">
                    <div class="w-12 h-12 bg-brand-mediqo text-white rounded-full flex items-center justify-center absolute -top-6 left-8 shadow-lg">
                        <i class="ph ph-bed text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-brand-navy mb-2 mt-4">PATIENT WEAR</h3>
                    <p class="text-sm text-gray-600 mb-6">Soft on skin.<br>Easy to wear.</p>
                    <span class="text-brand-mediqo font-bold text-xs uppercase tracking-widest group-hover:underline">EXPLORE <i class="ph ph-arrow-right ml-1"></i></span>
                </div>
            </a>

            <!-- Category 6: Pharmacy Wear -->
            <a href="{{ url('/shop') }}" class="category-card group bg-gray-100/50 border border-gray-200 rounded-xl overflow-hidden block">
                <div class="h-56 w-full flex items-center justify-center pt-8 px-4 overflow-hidden bg-[url('https://placehold.co/800x400/f8fafc/e2e8f0?text=Pharmacy+Shelves')] bg-cover bg-center">
                    <img src="https://placehold.co/500x400/transparent/475569?text=Pharmacist" alt="Pharmacy Wear" class="h-full object-contain mix-blend-multiply object-bottom transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 bg-white relative">
                    <div class="w-12 h-12 bg-brand-mediqo text-white rounded-full flex items-center justify-center absolute -top-6 left-8 shadow-lg">
                        <i class="ph ph-pill text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-brand-navy mb-2 mt-4">PHARMACY WEAR</h3>
                    <p class="text-sm text-gray-600 mb-6">Smart. Simple.<br>Made for professionals.</p>
                    <span class="text-brand-mediqo font-bold text-xs uppercase tracking-widest group-hover:underline">EXPLORE <i class="ph ph-arrow-right ml-1"></i></span>
                </div>
            </a>

        </div>
    </section>

    <!-- Featured Scrub Collection -->
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-20 relative">
        <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-2xl font-heading font-bold text-brand-navy tracking-tight uppercase">Featured Scrub Collection</h2>
            <a href="{{ url('/shop') }}" class="border border-gray-300 hover:border-brand-navy text-brand-navy font-bold text-xs px-4 py-2 uppercase tracking-widest transition-colors flex items-center gap-1 rounded-sm hidden sm:flex">
                VIEW ALL <i class="ph ph-arrow-right"></i>
            </a>
        </div>

        <!-- Carousel Container -->
        <div class="flex overflow-x-auto hide-scrollbar gap-6 pb-4 relative">
            <!-- Card 1 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[280px] lg:w-[calc(25%-1.125rem)]">
                <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                    <img src="https://placehold.co/300x400/f4f5f7/475569?text=V-Neck+Scrub+Top" alt="V-Neck Scrub Top" class="h-full object-contain">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                        <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#7c1c2b] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-white border border-gray-300"></div>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">V-Neck Scrub Top</h3>
                    <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                        <span class="text-gray-550 font-medium ml-1">4.6 (128)</span>
                    </div>
                    <div class="font-bold text-lg text-brand-navy mb-4">₹699</div>
                    <a href="{{ url('/product-detail/v-neck-scrub-top') }}" class="w-full text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2.5 rounded-sm transition-colors mt-auto">VIEW PRODUCT</a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[280px] lg:w-[calc(25%-1.125rem)]">
                <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                    <img src="https://placehold.co/300x400/f4f5f7/475569?text=Premium+Scrub+Set" alt="Premium Scrub Set" class="h-full object-contain">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                        <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#0369a1] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-white border border-gray-300"></div>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Premium Scrub Set</h3>
                    <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                        <span class="text-gray-550 font-medium ml-1">4.7 (96)</span>
                    </div>
                    <div class="font-bold text-lg text-brand-navy mb-4">₹1,499</div>
                    <a href="{{ url('/product-detail/premium-scrub-set') }}" class="w-full text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2.5 rounded-sm transition-colors mt-auto">VIEW PRODUCT</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[280px] lg:w-[calc(25%-1.125rem)]">
                <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                    <img src="https://placehold.co/300x400/f4f5f7/475569?text=Stretch+Scrub+Set" alt="Stretch Scrub Set" class="h-full object-contain">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                        <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#52525b] border border-gray-300"></div>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Stretch Scrub Set</h3>
                    <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                        <span class="text-gray-550 font-medium ml-1">4.8 (74)</span>
                    </div>
                    <div class="font-bold text-lg text-brand-navy mb-4">₹2,199</div>
                    <a href="{{ url('/product-detail/stretch-scrub-set') }}" class="w-full text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2.5 rounded-sm transition-colors mt-auto">VIEW PRODUCT</a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[280px] lg:w-[calc(25%-1.125rem)]">
                <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                    <img src="https://placehold.co/300x400/f4f5f7/475569?text=Women's+Scrub+Set" alt="Women's Scrub Set" class="h-full object-contain">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                        <div class="w-3 h-3 rounded-full bg-[#7c1c2b] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-white border border-gray-300"></div>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Women's Scrub Set</h3>
                    <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                        <span class="text-gray-555 font-medium ml-1">4.6 (58)</span>
                    </div>
                    <div class="font-bold text-lg text-brand-navy mb-4">₹1,499</div>
                    <a href="{{ url('/product-detail/womens-scrub-set') }}" class="w-full text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2.5 rounded-sm transition-colors mt-auto">VIEW PRODUCT</a>
                </div>
            </div>
        </div>
        
        <a href="{{ url('/shop') }}" class="mt-6 border border-gray-300 text-brand-navy font-bold text-sm px-4 py-3 uppercase tracking-widest flex items-center justify-center gap-2 rounded-sm sm:hidden">
            VIEW ALL <i class="ph ph-arrow-right"></i>
        </a>
    </section>

    <!-- Hospital Branding Solutions Banner -->
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-20">
        <div class="bg-[#e9f2f5] rounded-xl overflow-hidden flex flex-col lg:flex-row relative">
            
            <div class="lg:w-3/5 p-8 lg:p-12 z-10 flex flex-col justify-center">
                <h2 class="text-2xl lg:text-3xl font-heading font-extrabold text-brand-navy mb-2 tracking-tight">HOSPITAL BRANDING SOLUTIONS</h2>
                <p class="text-gray-600 mb-10 max-w-lg">Elevate your identity with customized embroidered uniforms.</p>
                
                <a href="{{ url('/shop') }}" class="border border-brand-mediqo text-brand-mediqo hover:bg-brand-mediqo hover:text-white font-bold text-xs px-6 py-3 rounded-sm transition-colors uppercase tracking-widest inline-flex items-center gap-2 w-fit mb-12">
                    CUSTOMIZE NOW <i class="ph ph-arrow-right"></i>
                </a>

                <!-- 4 Step Process -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-brand-mediqo text-2xl mb-3 shadow-sm relative">
                            <i class="ph ph-upload-simple"></i>
                            <div class="absolute -top-2 -right-2 bg-brand-navy text-white text-[0.6rem] font-bold w-4 h-4 rounded-full flex items-center justify-center">1</div>
                        </div>
                        <h4 class="font-bold text-[0.65rem] text-brand-navy uppercase mb-1">1. UPLOAD LOGO</h4>
                        <p class="text-[0.6rem] text-gray-500">Upload your logo<br>in vector format</p>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <!-- Connecting Line -->
                        <div class="hidden sm:block absolute top-6 -left-1/2 w-full h-px bg-gray-300 border border-dashed border-gray-300 -z-10"></div>
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-brand-mediqo text-2xl mb-3 shadow-sm relative">
                            <i class="ph ph-t-shirt"></i>
                            <div class="absolute -top-2 -right-2 bg-brand-navy text-white text-[0.6rem] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</div>
                        </div>
                        <h4 class="font-bold text-[0.65rem] text-brand-navy uppercase mb-1">2. CHOOSE PLACEMENT</h4>
                        <p class="text-[0.6rem] text-gray-500">Select placement<br>(Chest / Sleeve / Back)</p>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="hidden sm:block absolute top-6 -left-1/2 w-full h-px bg-gray-300 border border-dashed border-gray-300 -z-10"></div>
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-brand-mediqo text-2xl mb-3 shadow-sm relative">
                            <i class="ph ph-shield-check"></i>
                            <div class="absolute -top-2 -right-2 bg-brand-navy text-white text-[0.6rem] font-bold w-4 h-4 rounded-full flex items-center justify-center">3</div>
                        </div>
                        <h4 class="font-bold text-[0.65rem] text-brand-navy uppercase mb-1">3. PREVIEW DESIGN</h4>
                        <p class="text-[0.6rem] text-gray-500">See how it looks on<br>your uniform</p>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="hidden sm:block absolute top-6 -left-1/2 w-full h-px bg-gray-300 border border-dashed border-gray-300 -z-10"></div>
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-brand-mediqo text-2xl mb-3 shadow-sm relative">
                            <i class="ph ph-file-text"></i>
                            <div class="absolute -top-2 -right-2 bg-brand-navy text-white text-[0.6rem] font-bold w-4 h-4 rounded-full flex items-center justify-center">4</div>
                        </div>
                        <h4 class="font-bold text-[0.65rem] text-brand-navy uppercase mb-1">4. GET BULK QUOTE</h4>
                        <p class="text-[0.6rem] text-gray-500">Get best pricing for<br>your requirement</p>
                    </div>
                </div>
            </div>

            <!-- Graphic Side -->
            <div class="lg:w-2/5 bg-brand-mediqo relative flex items-center justify-center overflow-hidden min-h-[300px]">
                <div class="absolute inset-0 bg-[url('https://placehold.co/600x600/145c75/145c75?text=Fabric+Texture')] opacity-30 mix-blend-multiply bg-cover bg-center"></div>
                <div class="relative z-10 flex items-center gap-3">
                    <i class="ph ph-cross text-white text-5xl"></i>
                    <div class="text-white">
                        <div class="text-3xl font-heading font-bold leading-none tracking-tight">CAREMAX</div>
                        <div class="text-sm tracking-widest uppercase">HOSPITAL</div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Why Choose & Bulk Enquiry Form -->
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-20">
        <div class="bg-white rounded-xl shadow-[0_4px_30px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col lg:flex-row overflow-hidden">
            
            <!-- Left: Why Choose -->
            <div class="lg:w-5/12 p-8 lg:p-12 lg:border-r border-gray-100 flex flex-col justify-center">
                <h2 class="text-2xl lg:text-3xl font-heading font-extrabold text-brand-navy mb-8 tracking-tight">WHY CHOOSE FM MEDIQO?</h2>
                
                <div class="flex gap-4 sm:gap-8 justify-between lg:justify-start lg:gap-10 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center text-gray-600 text-xl mb-3">
                            <i class="ph ph-intersect"></i>
                        </div>
                        <span class="text-[0.65rem] font-bold text-brand-navy">4-Way<br>Stretch</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center text-gray-600 text-xl mb-3">
                            <i class="ph ph-x-circle"></i>
                        </div>
                        <span class="text-[0.65rem] font-bold text-brand-navy">Anti<br>Wrinkle</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center text-gray-600 text-xl mb-3">
                            <i class="ph ph-drop"></i>
                        </div>
                        <span class="text-[0.65rem] font-bold text-brand-navy">Easy<br>Wash</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center text-gray-600 text-xl mb-3">
                            <i class="ph ph-paint-brush"></i>
                        </div>
                        <span class="text-[0.65rem] font-bold text-brand-navy">Color<br>Fastness</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center text-gray-600 text-xl mb-3">
                            <i class="ph ph-needle"></i>
                        </div>
                        <span class="text-[0.65rem] font-bold text-brand-navy">Premium<br>Embroidery</span>
                    </div>
                </div>
            </div>

            <!-- Right: Enquiry Form -->
            <div class="lg:w-7/12 p-8 lg:p-12 bg-gray-50/50">
                <div class="flex flex-col md:flex-row gap-8 mb-8">
                    <div class="md:w-1/2">
                        <h2 class="text-xl font-heading font-extrabold text-brand-navy mb-2 tracking-tight uppercase">BULK ORDER ENQUIRY</h2>
                        <p class="text-sm text-gray-600 mb-6">Get best pricing for hospitals, clinics, labs & healthcare institutions.</p>
                        
                        <div class="flex gap-4 text-brand-mediqo">
                            <div class="flex flex-col items-center">
                                <i class="ph ph-buildings text-2xl mb-1"></i>
                                <span class="text-[0.55rem] uppercase font-bold text-gray-500">Hospitals</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <i class="ph ph-house-line text-2xl mb-1"></i>
                                <span class="text-[0.55rem] uppercase font-bold text-gray-500">Clinics</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <i class="ph ph-flask text-2xl mb-1"></i>
                                <span class="text-[0.55rem] uppercase font-bold text-gray-500">Labs</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <i class="ph ph-graduation-cap text-2xl mb-1"></i>
                                <span class="text-[0.55rem] uppercase font-bold text-gray-500 text-center">Medical<br>Colleges</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:w-1/2">
                        <form class="space-y-4" action="{{ url('/bulkorder') }}" method="POST">
                            @csrf
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Hospital / Institution Name *</label>
                                <input type="text" name="hospital_name" class="w-full border border-gray-300 px-3 py-2 text-sm rounded-sm focus:outline-none focus:border-brand-mediqo bg-white" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Contact Person *</label>
                                    <input type="text" name="contact_person" class="w-full border border-gray-300 px-3 py-2 text-sm rounded-sm focus:outline-none focus:border-brand-mediqo bg-white" required>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Phone Number *</label>
                                    <input type="tel" name="phone" class="w-full border border-gray-300 px-3 py-2 text-sm rounded-sm focus:outline-none focus:border-brand-mediqo bg-white" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Email Address *</label>
                                    <input type="email" name="email" class="w-full border border-gray-300 px-3 py-2 text-sm rounded-sm focus:outline-none focus:border-brand-mediqo bg-white" required>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Quantity Required *</label>
                                    <select name="quantity" class="w-full border border-gray-300 px-3 py-2 text-sm rounded-sm focus:outline-none focus:border-brand-mediqo bg-white">
                                        <option value="20-50">20 - 50 Pcs</option>
                                        <option value="51-100">51 - 100 Pcs</option>
                                        <option value="101-500">101 - 500 Pcs</option>
                                        <option value="500+">500+ Pcs</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Upload Logo (Optional)</label>
                                <div class="border border-dashed border-gray-300 px-3 py-2 bg-white rounded-sm text-sm text-gray-500 flex items-center cursor-pointer hover:bg-gray-50">
                                    <button type="button" class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded border border-gray-300 mr-3">Choose File</button>
                                    No file chosen
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-brand-gold hover:bg-yellow-600 text-white font-bold text-sm px-4 py-3 rounded-sm transition-colors uppercase tracking-widest mt-2">
                                REQUEST QUOTE
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Trust Stats Banner -->
    <section class="border-t border-gray-200 py-8 mt-12 mb-8">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
            <div class="flex flex-col items-center justify-center">
                <i class="ph ph-buildings text-3xl text-brand-navy mb-2"></i>
                <div class="font-heading font-extrabold text-xl text-brand-navy">500+</div>
                <div class="text-[0.65rem] uppercase text-gray-500 font-bold tracking-wide">Institutions Served</div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <i class="ph ph-users text-3xl text-brand-navy mb-2"></i>
                <div class="font-heading font-extrabold text-xl text-brand-navy">2 Lakh+</div>
                <div class="text-[0.65rem] uppercase text-gray-500 font-bold tracking-wide">Uniforms Delivered</div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <i class="ph ph-clock text-3xl text-brand-navy mb-2"></i>
                <div class="font-heading font-extrabold text-xl text-brand-navy">10+</div>
                <div class="text-[0.65rem] uppercase text-gray-500 font-bold tracking-wide">Years of Experience</div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <i class="ph ph-truck text-3xl text-brand-navy mb-2"></i>
                <div class="font-heading font-extrabold text-xl text-brand-navy">PAN India</div>
                <div class="text-[0.65rem] uppercase text-gray-500 font-bold tracking-wide">Delivery</div>
            </div>
            <div class="flex flex-col items-center justify-center col-span-2 md:col-span-1">
                <i class="ph ph-star text-3xl text-brand-navy mb-2"></i>
                <div class="font-heading font-extrabold text-xl text-brand-navy">4.8/5</div>
                <div class="text-[0.65rem] uppercase text-gray-500 font-bold tracking-wide">Customer Rating</div>
            </div>
        </div>
    </section>
@endsection
