@extends('layouts.app')

@php
    $type = request('type', 'scrubs');
@endphp

@section('styles')
    @if ($type === 'corporate')
        <style>
            .emb-card.active{border-color:#16a34a;background:#f0fdf4;}
            .emb-card.active .emb-check{display:flex;}
            .emb-check{display:none;}
            .pos-tab.active{border-color:#16a34a;color:#16a34a;background:#f0fdf4;}
            .pos-tab{border-bottom:2px solid transparent;}
        </style>
    @elseif ($type === 'chef-coat')
        <style>
            .emb-card.active{border-color:#c79b3e;background:#fdf8ee;}
            .emb-card.active .emb-check{display:flex;}
            .emb-check{display:none;}
            .pos-card.active{border-color:#c79b3e;background:#fdf8ee;}
        </style>
    @else
        <style>
            .step-circle {
                width: 2rem; height: 2rem;
                border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.85rem; font-weight: 700;
            }
            .emb-card.active { border-color: #145c75; background: #eaf4f8; }
            .emb-card.active .emb-check { display: flex; }
            .emb-check { display: none; }
            .pos-card.active { border-color: #145c75; background: #eaf4f8; }
            .pos-card.active .pos-check { display: flex; }
            .pos-check { display: none; }
        </style>
    @endif
@endsection

@section('content')
    @if ($type === 'corporate')
        <!-- BREADCRUMB -->
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-brand-workon">Home</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="#" class="hover:text-brand-workon">FM Workon</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="#" class="hover:text-brand-workon">Corporate Uniforms</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="#" class="hover:text-brand-workon">Shirts</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="#" class="hover:text-brand-workon">Men's Shirt</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <span class="text-gray-800 font-medium">White Shirt with Navy Piping</span>
        </div>

        <!-- MAIN GRID -->
        <main class="max-w-[1600px] mx-auto px-4 lg:px-8 pb-16">
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- Column 1: Images -->
                <div class="flex gap-4 lg:w-[400px] shrink-0">
                    <!-- Thumbnails -->
                    <div class="hidden lg:flex flex-col gap-3 w-20 shrink-0 pt-4">
                        <button class="border border-gray-250 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Front" alt="Front" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Back" alt="Back" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Pocket" alt="Pocket" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Fabric" alt="Fabric" class="h-full object-contain mix-blend-multiply">
                        </button>
                    </div>

                    <!-- Main Image -->
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-xl flex items-center justify-center min-h-[500px] p-6 border border-gray-100 h-full relative">
                            <img src="https://placehold.co/400x580/f8fafc/1a1a1a?text=White+Shirt+Navy+Piping+Model" alt="White Shirt with Navy Piping" class="h-full max-h-[580px] object-contain mix-blend-multiply">
                            
                            <!-- Overlay matching the left chest embroidery on the main image as well -->
                            <div class="absolute top-[35%] right-[28%] text-center pointer-events-none" style="font-family: 'Outfit', sans-serif;">
                                <div class="flex flex-col items-center mb-0.5 text-[#0f172a]/60 scale-75 transform origin-center">
                                    <span class="text-[0.7rem] font-extrabold tracking-widest leading-none">AC</span>
                                    <span class="text-[0.25rem] tracking-[0.25em] font-bold uppercase mt-0.5">AURICORP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Product Info Panel -->
                <div class="lg:w-80 shrink-0">
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <span class="bg-brand-workon text-white text-[0.6rem] font-bold px-2 py-0.5 rounded-sm uppercase tracking-wide">Best Seller</span>
                        <h1 class="text-xl font-heading font-extrabold text-brand-navy mt-3 mb-1 leading-snug">White Shirt with<br>Navy Piping</h1>
                        <div class="flex items-center gap-1 text-yellow-500 text-sm mb-3">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-500 text-xs ml-1">(128 Reviews)</span>
                        </div>
                        <div class="font-extrabold text-2xl text-brand-navy mb-1">₹699</div>
                        <div class="text-xs text-gray-400 mb-6">(Inclusive of all taxes)</div>

                        <!-- Feature Badges -->
                        <div class="flex flex-col gap-3 mb-6 pb-6 border-b border-gray-100">
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <i class="ph ph-intersect text-brand-workon text-xl"></i>
                                <div>
                                    <div class="font-bold text-brand-navy leading-none">Premium Fabric</div>
                                    <div class="text-[0.65rem] text-gray-400">Easy Care</div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <i class="ph ph-shield-check text-brand-workon text-xl"></i>
                                <div>
                                    <div class="font-bold text-brand-navy leading-none">Durable</div>
                                    <div class="text-[0.65rem] text-gray-400">Long Lasting</div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <i class="ph ph-star text-brand-workon text-xl"></i>
                                <div>
                                    <div class="font-bold text-brand-navy leading-none">Professional Fit</div>
                                    <div class="text-[0.65rem] text-gray-400">Tailored for Comfort</div>
                                </div>
                            </div>
                        </div>

                        <!-- Fabric Dropdown -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-brand-navy uppercase tracking-wider mb-2">Fabric <i class="ph ph-info text-gray-400"></i></label>
                            <div class="relative">
                                <select class="w-full border border-gray-300 text-gray-700 text-sm py-2 px-3 rounded-sm focus:outline-none focus:border-brand-workon appearance-none bg-white pr-10">
                                    <option>Polycotton (65% Polyester, 35% Cotton)</option>
                                    <option>100% Cotton</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Size -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold text-brand-navy uppercase tracking-wider">Size <i class="ph ph-info text-gray-400"></i></label>
                                <a href="#" class="text-xs text-brand-workon hover:underline font-semibold flex items-center gap-1"><i class="ph ph-ruler"></i> Size Chart</a>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <div class="relative"><input type="radio" name="size" id="sz-s" class="peer hidden"><label for="sz-s" class="block px-2.5 py-1.5 border border-gray-300 text-xs text-gray-700 cursor-pointer hover:border-gray-450 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm min-w-[2.5rem] text-center">S</label></div>
                                <div class="relative"><input type="radio" name="size" id="sz-m" class="peer hidden" checked><label for="sz-m" class="block px-2.5 py-1.5 border border-brand-navy bg-brand-navy text-white text-xs cursor-pointer transition-colors rounded-sm min-w-[2.5rem] text-center">M</label></div>
                                <div class="relative"><input type="radio" name="size" id="sz-l" class="peer hidden"><label for="sz-l" class="block px-2.5 py-1.5 border border-gray-300 text-xs text-gray-700 cursor-pointer hover:border-gray-450 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm min-w-[2.5rem] text-center">L</label></div>
                                <div class="relative"><input type="radio" name="size" id="sz-xl" class="peer hidden"><label for="sz-xl" class="block px-2.5 py-1.5 border border-gray-300 text-xs text-gray-700 cursor-pointer hover:border-gray-450 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm min-w-[2.5rem] text-center">XL</label></div>
                                <div class="relative"><input type="radio" name="size" id="sz-2xl" class="peer hidden"><label for="sz-2xl" class="block px-2.5 py-1.5 border border-gray-300 text-xs text-gray-700 cursor-pointer hover:border-gray-450 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm min-w-[2.5rem] text-center">2XL</label></div>
                                <div class="relative"><input type="radio" name="size" id="sz-3xl" class="peer hidden"><label for="sz-3xl" class="block px-2.5 py-1.5 border border-gray-300 text-xs text-gray-700 cursor-pointer hover:border-gray-450 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm min-w-[2.5rem] text-center">3XL</label></div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6 flex items-center gap-3">
                            <span class="text-xs font-bold text-brand-navy uppercase tracking-wider">Quantity</span>
                            <div class="flex items-center border border-gray-300 rounded-sm">
                                <button class="px-2.5 py-1.5 text-gray-400 hover:text-brand-navy"><i class="ph ph-minus text-sm"></i></button>
                                <input type="number" value="1" min="1" class="w-8 text-center text-sm font-semibold text-brand-navy focus:outline-none">
                                <button class="px-2.5 py-1.5 text-gray-400 hover:text-brand-navy"><i class="ph ph-plus text-sm"></i></button>
                            </div>
                        </div>

                        <!-- Trust -->
                        <div class="flex flex-col gap-2.5 text-[0.65rem] text-gray-500 mb-6 border-t border-gray-100 pt-4">
                            <span class="flex items-center gap-1.5"><i class="ph ph-arrow-counter-clockwise text-sm text-brand-workon"></i> Easy Returns & Exchanges</span>
                            <span class="flex items-center gap-1.5"><i class="ph ph-shield-check text-sm text-brand-workon"></i> 100% Secure Payment</span>
                            <span class="flex items-center gap-1.5"><i class="ph ph-truck text-sm text-brand-workon"></i> Fast & Free Delivery 3-6 Days</span>
                        </div>

                        <!-- CTAs -->
                        <div class="flex flex-col gap-2.5">
                            <button class="border border-gray-300 hover:border-brand-navy text-brand-navy font-bold text-xs py-3 rounded-sm flex items-center justify-center gap-1.5 transition-colors">
                                <i class="ph ph-shopping-cart"></i> ADD TO CART
                            </button>
                            <button class="bg-[#145c75] hover:bg-[#0f4659] text-white font-bold text-xs py-3 rounded-sm flex items-center justify-center gap-1.5 transition-colors">
                                <i class="ph ph-lightning"></i> BUY NOW
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Customization Form -->
                <div class="flex-1 bg-white border border-gray-200 rounded-xl p-6">
                    <h2 class="text-xl font-heading font-extrabold text-brand-navy mb-1">CUSTOMIZE YOUR UNIFORM</h2>
                    <p class="text-sm text-gray-500 mb-6">Add logo, name and more. Make it yours.</p>

                    <!-- Step 1: Embroidery Type -->
                    <div class="mb-6">
                        <h3 class="font-bold text-xs text-brand-navy uppercase tracking-wider mb-3">1. Embroidery Type</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="emb-card border border-gray-200 rounded-lg p-3 cursor-pointer text-center relative hover:border-gray-300 transition-all" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-4 h-4 bg-brand-workon rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-[0.55rem]"></i>
                                </div>
                                <div class="text-lg font-bold text-gray-400 mb-1">Aa</div>
                                <div class="font-bold text-[0.65rem] text-brand-navy mb-0.5">Text Only</div>
                                <div class="text-[0.55rem] text-gray-400">Name / Designation</div>
                            </div>
                            <div class="emb-card active border border-brand-workon rounded-lg p-3 cursor-pointer text-center relative transition-all" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-4 h-4 bg-brand-workon rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-[0.55rem]"></i>
                                </div>
                                <div class="flex items-center justify-center gap-0.5 text-brand-workon mb-1">
                                    <i class="ph ph-shield text-base"></i><span class="text-base font-bold">Aa</span>
                                </div>
                                <div class="font-bold text-[0.65rem] text-brand-navy mb-0.5">Logo + Text</div>
                                <div class="text-[0.55rem] text-gray-400">Add logo with name & designation</div>
                            </div>
                            <div class="emb-card border border-gray-200 rounded-lg p-3 cursor-pointer text-center relative hover:border-gray-300 transition-all" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-4 h-4 bg-brand-workon rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-[0.55rem]"></i>
                                </div>
                                <div class="text-brand-workon mb-1"><i class="ph ph-shield text-xl"></i></div>
                                <div class="font-bold text-[0.65rem] text-brand-navy mb-0.5">Logo Only</div>
                                <div class="text-[0.55rem] text-gray-400">Add logo only</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Add Details -->
                    <div class="mb-6">
                        <h3 class="font-bold text-xs text-brand-navy uppercase tracking-wider mb-3">2. Add Details</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1">Your Name (Optional)</label>
                                <input id="corpName" type="text" value="Rahul Sharma" placeholder="Enter your name..."
                                    class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-workon"
                                    oninput="updatePreview()">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1">Designation (Optional)</label>
                                <input id="corpDesig" type="text" value="Marketing Manager" placeholder="Enter designation..."
                                    class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-brand-workon"
                                    oninput="updatePreview()">
                            </div>
                            <!-- Upload Logo -->
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1">Upload Logo (Optional)</label>
                                <div class="border border-dashed border-gray-300 rounded-sm px-4 py-4 flex flex-col items-center justify-center gap-1.5 cursor-pointer hover:bg-gray-50 transition-colors">
                                    <i class="ph ph-upload-simple text-2xl text-gray-400"></i>
                                    <span class="text-xs text-gray-500 font-semibold">Upload Logo</span>
                                    <span class="text-[0.6rem] text-gray-400">PNG, JPG up to 2MB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Position -->
                    <div>
                        <h3 class="font-bold text-xs text-brand-navy uppercase tracking-wider mb-3">3. Choose Embroidery Position</h3>
                        <div class="flex gap-3">
                            <div class="pos-card active border-2 border-brand-workon rounded-lg p-3 cursor-pointer text-center w-28 relative bg-green-50" onclick="selectPos(this)">
                                <div class="absolute top-2 right-2 w-4 h-4 bg-brand-workon rounded-full flex items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-[0.55rem]"></i>
                                </div>
                                <div class="h-12 flex items-center justify-center mb-1 text-gray-450">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-10 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="16" y="26" width="12" height="9" rx="1" fill="#16a34a" stroke="none"/>
                                    </svg>
                                </div>
                                <div class="text-[0.65rem] font-bold text-brand-navy">Left Chest</div>
                                <div class="text-[0.55rem] text-gray-500">(Included)</div>
                            </div>
                            <div class="pos-card border border-gray-200 rounded-lg p-3 cursor-pointer text-center w-28 hover:border-gray-300 relative transition-all" onclick="selectPos(this)">
                                <div class="h-12 flex items-center justify-center mb-1 text-gray-350">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-10 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="16" y="30" width="10" height="8" rx="1" fill="#16a34a" stroke="none" opacity="0.4"/>
                                    </svg>
                                </div>
                                <div class="text-[0.65rem] font-bold text-brand-navy">Left Pocket</div>
                                <div class="text-[0.55rem] text-gray-500">+ ₹100</div>
                            </div>
                            <div class="pos-card border border-gray-200 rounded-lg p-3 cursor-pointer text-center w-28 hover:border-gray-300 relative transition-all" onclick="selectPos(this)">
                                <div class="h-12 flex items-center justify-center mb-1 text-gray-350">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-10 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="33" y="30" width="14" height="10" rx="1" fill="#16a34a" stroke="none" opacity="0.4"/>
                                    </svg>
                                </div>
                                <div class="text-[0.65rem] font-bold text-brand-navy">Back Center</div>
                                <div class="text-[0.55rem] text-gray-500">+ ₹150</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 4: Live Preview -->
                <div class="lg:w-[320px] shrink-0">
                    <div class="border border-gray-200 rounded-xl overflow-hidden sticky top-24 bg-white shadow-sm">
                        <!-- Tabs -->
                        <div class="flex border-b border-gray-200 bg-gray-50">
                            <button class="pos-tab active flex-1 py-3 text-[0.65rem] font-bold text-center border-b-2 border-brand-workon text-brand-workon bg-green-50/50">Left Chest</button>
                            <button class="pos-tab flex-1 py-3 text-[0.65rem] font-semibold text-gray-400 text-center hover:text-brand-navy transition-colors">Left Pocket<br><span class="text-[0.55rem]">+ ₹100</span></button>
                            <button class="pos-tab flex-1 py-3 text-[0.65rem] font-semibold text-gray-400 text-center hover:text-brand-navy transition-colors">Back Center<br><span class="text-[0.55rem]">+ ₹150</span></button>
                        </div>

                        <div class="text-center py-2.5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-200 bg-gray-50/50">Live Preview</div>

                        <!-- Zoomed Preview image with embroidery directly over fabric (Realistic look) -->
                        <div class="relative bg-gray-50 h-[340px] flex items-center justify-center overflow-hidden">
                            <img src="https://placehold.co/600x680/f8fafc/475569?text=White+Shirt+Zoomed+Chest" alt="Shirt Preview" class="absolute inset-0 w-full h-full object-cover">
                            
                            <!-- Real direct embroidery overlay (No card container, just embroidery directly on model's shirt) -->
                            <div class="absolute top-[48%] left-[50%] -translate-x-1/2 -translate-y-1/2 text-center pointer-events-none select-none animate-fade-in" style="font-family: 'Outfit', sans-serif;">
                                <div class="flex flex-col items-center mb-1 text-[#0f172a]/90">
                                    <span class="text-xl font-extrabold tracking-widest leading-none">AC</span>
                                    <span class="text-[0.45rem] tracking-[0.25em] font-bold uppercase mt-0.5">AURICORP</span>
                                </div>
                                <div class="text-[#0f172a] font-bold text-sm tracking-wide leading-tight mt-2.5" id="previewName">Rahul Sharma</div>
                                <div class="text-[#0f172a]/80 text-[0.65rem] tracking-wider leading-none mt-1" id="previewDesig">Marketing Manager</div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 flex items-start gap-2">
                            <i class="ph ph-info text-brand-workon text-sm mt-0.5 shrink-0"></i>
                            <p class="text-[0.65rem] text-gray-500 leading-relaxed">Preview is approximate. Actual embroidery may vary slightly.</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>



    @elseif ($type === 'chef-coat')
        <!-- BREADCRUMB -->
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-brand-hostra">Home</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="{{ url('/categories/hostra') }}" class="hover:text-brand-hostra">Hostra</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="{{ url('/shop') }}" class="hover:text-brand-hostra">Chef Coat</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <span class="text-gray-800 font-medium">Customize</span>
        </div>

        <!-- MAIN GRID -->
        <main class="max-w-[1600px] mx-auto px-4 lg:px-8 pb-16">
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- Column 1: Images -->
                <div class="flex gap-4 lg:w-[400px] shrink-0">
                    <!-- Thumbnails -->
                    <div class="hidden lg:flex flex-col gap-3 w-20 shrink-0 pt-4">
                        <button class="border border-gray-250 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Front" alt="Front" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Back" alt="Back" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Button" alt="Buttons" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-gray-50 flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/80x110/f8fafc/1a1a1a?text=Fabric" alt="Fabric" class="h-full object-contain mix-blend-multiply">
                        </button>
                    </div>

                    <!-- Main Product Image -->
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-xl flex items-center justify-center min-h-[500px] p-6 border border-gray-100 h-full relative">
                            <img src="https://placehold.co/400x580/f8fafc/1a1a1a?text=Black+Gold+Chef+Coat+Model" alt="Chef Coat – Black with Gold Piping" class="h-full max-h-[580px] object-contain mix-blend-multiply">
                        </div>
                    </div>
                </div>

                <!-- Customize Form -->
                <div class="flex-1 bg-white border border-gray-200 rounded-xl p-6 lg:p-8">
                    <h1 class="text-2xl font-heading font-extrabold text-brand-navy mb-1">CUSTOMIZE YOUR UNIFORM</h1>
                    <p class="text-sm text-gray-500 mb-8">Personalize with logo, name and more. Choose your placement.</p>

                    <!-- Step 1 -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-brand-hostra text-white flex items-center justify-center font-bold text-sm">1</div>
                            <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm">Select Embroidery Type</h2>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Text Only (Active) -->
                            <div class="emb-card active border-2 rounded-lg p-4 cursor-pointer text-center relative" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-5 h-5 bg-brand-hostra rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="mb-2 flex justify-center">
                                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="2" width="32" height="32" rx="4" stroke="#c79b3e" stroke-width="1.5" stroke-dasharray="4 2"/>
                                        <text x="18" y="23" text-anchor="middle" font-size="14" font-weight="700" fill="#c79b3e" font-family="serif">Aa</text>
                                    </svg>
                                </div>
                                <div class="font-bold text-xs text-brand-navy mb-1">Text Only</div>
                                <div class="text-[0.6rem] text-gray-500">Name / Designation</div>
                            </div>
                            <!-- Logo + Text -->
                            <div class="emb-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer text-center relative hover:border-gray-300" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-5 h-5 bg-brand-hostra rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center gap-1 mb-2 text-gray-400">
                                    <i class="ph ph-shield text-xl"></i><span class="text-base font-bold">Aa</span>
                                </div>
                                <div class="font-bold text-xs text-brand-navy mb-1">Logo + Text</div>
                                <div class="text-[0.6rem] text-gray-500">Add logo with name & designation</div>
                            </div>
                            <!-- Logo Only -->
                            <div class="emb-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer text-center relative hover:border-gray-300" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-5 h-5 bg-brand-hostra rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="mb-2 text-gray-400"><i class="ph ph-shield text-2xl"></i></div>
                                <div class="font-bold text-xs text-brand-navy mb-1">Logo Only</div>
                                <div class="text-[0.6rem] text-gray-500">Add logo without text</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-brand-hostra text-white flex items-center justify-center font-bold text-sm">2</div>
                            <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm">Enter Details</h2>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1.5">
                                    Your Name / Title *
                                    <span class="text-gray-400 font-normal ml-2">(Max 20 characters)</span>
                                </label>
                                <input id="chefName" type="text" value="Chef Arjun" maxlength="20"
                                    class="w-full border border-gray-300 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:border-brand-hostra"
                                    oninput="updatePreview()">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1.5">
                                    Designation <span class="text-gray-400 font-normal">(Optional)</span>
                                    <span class="text-gray-400 font-normal ml-2">(Max 25 characters)</span>
                                </label>
                                <input id="chefDesig" type="text" value="Executive Chef" maxlength="25"
                                    class="w-full border border-gray-300 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:border-brand-hostra"
                                    oninput="updatePreview()">
                            </div>
                            <!-- Logo Upload -->
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1.5">Upload Logo (Optional)</label>
                                <div class="border border-dashed border-gray-300 rounded-sm px-4 py-5 flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 transition-colors">
                                    <i class="ph ph-upload-simple text-2xl text-gray-400"></i>
                                    <span class="text-xs text-gray-500">Click to upload logo</span>
                                    <span class="text-[0.6rem] text-gray-400">PNG, JPG up to 2MB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Position -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-brand-hostra text-white flex items-center justify-center font-bold text-sm">3</div>
                            <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm">Choose Embroidery Position</h2>
                        </div>
                        <div class="flex gap-4 mb-4">
                            <!-- Left Chest (Active) -->
                            <div class="pos-card active border-2 rounded-lg p-3 cursor-pointer text-center w-36 relative" onclick="selectPos(this)">
                                <div class="absolute top-2 right-2 w-5 h-5 bg-brand-hostra rounded-full flex items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="h-16 flex items-center justify-center mb-2 text-gray-400">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-14 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="16" y="26" width="12" height="9" rx="1" fill="#c79b3e" stroke="none"/>
                                    </svg>
                                </div>
                                <div class="text-xs font-bold text-brand-navy">Left Chest</div>
                                <div class="text-[0.6rem] text-gray-500">(Included)</div>
                            </div>
                            <!-- Left Sleeve -->
                            <div class="pos-card border-2 border-gray-200 rounded-lg p-3 cursor-pointer text-center w-36 relative hover:border-gray-300" onclick="selectPos(this)">
                                <div class="h-16 flex items-center justify-center mb-2 text-gray-300">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-14 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="2" y="30" width="10" height="7" rx="1" fill="#c79b3e" stroke="none" opacity="0.5"/>
                                    </svg>
                                </div>
                                <div class="text-xs font-bold text-brand-navy">Left Sleeve</div>
                                <div class="text-[0.6rem] text-gray-500">+ ₹100</div>
                            </div>
                            <!-- Back Center -->
                            <div class="pos-card border-2 border-gray-200 rounded-lg p-3 cursor-pointer text-center w-36 relative hover:border-gray-300" onclick="selectPos(this)">
                                <div class="h-16 flex items-center justify-center mb-2 text-gray-300">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-14 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="33" y="28" width="14" height="10" rx="1" fill="#c79b3e" stroke="none" opacity="0.5"/>
                                    </svg>
                                </div>
                                <div class="text-xs font-bold text-brand-navy">Back Center</div>
                                <div class="text-[0.6rem] text-gray-500">+ ₹150</div>
                            </div>
                        </div>
                        <!-- Info -->
                        <div class="flex items-start gap-2 bg-yellow-50 border border-yellow-100 rounded-sm px-3 py-2.5">
                            <i class="ph ph-info text-brand-hostra mt-0.5 text-sm"></i>
                            <p class="text-xs text-gray-600">Embroidery will be done as per selected position.</p>
                        </div>
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="lg:w-[320px] shrink-0">
                    <div class="border border-gray-200 rounded-xl overflow-hidden sticky top-24 bg-white shadow-sm">
                        <!-- Position Tabs -->
                        <div class="flex border-b border-gray-200 bg-gray-50">
                            <button class="pos-tab active flex-1 py-3 text-xs font-bold text-brand-hostra border-b-2 border-brand-hostra bg-yellow-50/50">Left Chest</button>
                            <button class="pos-tab flex-1 py-3 text-xs font-semibold text-gray-400 hover:text-brand-navy transition-colors">Left Sleeve<br><span class="text-[0.6rem]">+ ₹100</span></button>
                            <button class="pos-tab flex-1 py-3 text-xs font-semibold text-gray-400 hover:text-brand-navy transition-colors">Back Center<br><span class="text-[0.6rem]">+ ₹150</span></button>
                        </div>

                        <div class="text-center py-2.5 text-[0.7rem] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-200 bg-gray-50/50">Live Preview</div>

                        <!-- Zoomed Preview image with embroidery directly over fabric -->
                        <div class="relative bg-[#1a1a1a] h-[340px] flex items-center justify-center overflow-hidden">
                            <img src="https://placehold.co/300x340/1a1a1a/333?text=Black+Chef+Coat+Close+Up" alt="Embroidery Preview" class="absolute inset-0 w-full h-full object-cover opacity-80">
                            
                            <!-- Direct embroidery overlay (Gold thread) -->
                            <div class="absolute top-[48%] left-[50%] -translate-x-1/2 -translate-y-1/2 text-center pointer-events-none select-none animate-fade-in" style="font-family: 'Outfit', sans-serif;">
                                <div class="text-[#c79b3e] font-bold text-sm tracking-wide leading-tight" id="previewName">Chef Arjun</div>
                                <div class="text-[#c79b3e]/85 text-[0.65rem] tracking-wider leading-none mt-1" id="previewDesig">Executive Chef</div>
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 flex items-start gap-2">
                            <i class="ph ph-info text-brand-hostra text-sm mt-0.5 shrink-0"></i>
                            <p class="text-[0.65rem] text-gray-500 leading-relaxed">Preview is approximate. Actual embroidery may vary slightly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>



    @else
        <!-- DEFAULT: SCRUBS -->
        <!-- BREADCRUMB -->
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-brand-mediqo">Home</a>
            <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="{{ url('/categories/mediqo') }}" class="hover:text-brand-mediqo">MediQo</a>
            <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="{{ url('/shop') }}" class="hover:text-brand-mediqo">Scrubs</a>
            <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <a href="#" class="hover:text-brand-mediqo">Women's Scrub Set - Wine</a>
            <i class="ph ph-caret-right mx-1 text-[10px]"></i>
            <span class="text-gray-800 font-medium">Customize</span>
        </div>

        <!-- MAIN GRID -->
        <main class="max-w-[1600px] mx-auto px-4 lg:px-8 pb-16">
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- Column 1: Images -->
                <div class="flex gap-4 lg:w-[400px] shrink-0">
                    <!-- Thumbnails -->
                    <div class="hidden lg:flex flex-col gap-3 w-20 shrink-0 pt-4">
                        <button class="border border-gray-250 hover:border-brand-navy rounded-md h-24 bg-brand-light flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/100x150/f4f5f7/475569?text=Front" alt="Front" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-brand-light flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/100x150/f4f5f7/475569?text=Back" alt="Back" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-brand-light flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/100x150/f4f5f7/475569?text=Pocket" alt="Pocket" class="h-full object-contain mix-blend-multiply">
                        </button>
                        <button class="border border-gray-200 hover:border-brand-navy rounded-md h-24 bg-brand-light flex items-center justify-center p-1 overflow-hidden transition-all">
                            <img src="https://placehold.co/100x150/f4f5f7/475569?text=Fabric" alt="Fabric" class="h-full object-contain mix-blend-multiply">
                        </button>
                    </div>

                    <!-- Main Product Image -->
                    <div class="flex-1">
                        <div class="bg-brand-light rounded-xl flex items-center justify-center min-h-[500px] p-6 border border-gray-100 h-full relative">
                            <img src="https://placehold.co/400x580/f4f5f7/475569?text=Wine+Scrub+Set+Model" alt="Women's Wine Scrub Set" class="h-full max-h-[580px] object-contain mix-blend-multiply">
                        </div>
                    </div>
                </div>

                <!-- COL 3: Customize Form -->
                <div class="flex-1 bg-white border border-gray-200 rounded-xl p-6 lg:p-8">
                    <h1 class="text-2xl font-heading font-extrabold text-brand-navy mb-1">CUSTOMIZE YOUR SCRUBS</h1>
                    <p class="text-sm text-gray-500 mb-8">Add logo, name and designation for a professional look.</p>

                    <!-- Step 1: Embroidery Type -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="step-circle bg-brand-mediqo text-white">1</div>
                            <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm">Embroidery Type</h2>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Name Only (Active) -->
                            <div class="emb-card active border-2 rounded-lg p-4 cursor-pointer text-center relative transition-all" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-5 h-5 bg-brand-mediqo rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="text-2xl text-brand-mediqo font-bold mb-2">Aa</div>
                                <div class="font-bold text-xs text-brand-navy mb-1">Name Only</div>
                                <div class="text-[0.6rem] text-gray-500 leading-snug">Add name and designation only</div>
                            </div>
                            <!-- Logo + Name -->
                            <div class="emb-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer text-center relative transition-all hover:border-gray-300" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-5 h-5 bg-brand-mediqo rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center gap-1 mb-2 text-gray-400">
                                    <i class="ph ph-shield text-xl"></i>
                                    <span class="text-base font-bold">Aa</span>
                                </div>
                                <div class="font-bold text-xs text-brand-navy mb-1">Logo + Name</div>
                                <div class="text-[0.6rem] text-gray-500 leading-snug">Add logo with name & designation</div>
                            </div>
                            <!-- Logo Only -->
                            <div class="emb-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer text-center relative transition-all hover:border-gray-300" onclick="selectEmb(this)">
                                <div class="emb-check absolute top-2 right-2 w-5 h-5 bg-brand-mediqo rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="mb-2 text-gray-500">
                                    <i class="ph ph-shield text-2xl"></i>
                                </div>
                                <div class="font-bold text-xs text-brand-navy mb-1">Logo Only</div>
                                <div class="text-[0.6rem] text-gray-500 leading-snug">Add logo only without text</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Add Details -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="step-circle bg-brand-mediqo text-white">2</div>
                            <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm">Add Details</h2>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1.5">
                                    Doctor / Staff Name *
                                    <span class="text-gray-400 font-normal ml-2">(Max 20 characters)</span>
                                </label>
                                <input id="staffName" type="text" value="Dr. Priya S" maxlength="20"
                                    class="w-full border border-gray-300 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:border-brand-mediqo transition-colors"
                                    oninput="updatePreview()">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-brand-navy mb-1.5">
                                    Designation
                                    <span class="text-gray-400 font-normal ml-1">(Optional)</span>
                                    <span class="text-gray-400 font-normal ml-2">(Max 25 characters)</span>
                                </label>
                                <input id="designation" type="text" value="Cardiology" maxlength="25"
                                    class="w-full border border-gray-300 rounded-sm px-4 py-2.5 text-sm focus:outline-none focus:border-brand-mediqo transition-colors"
                                    oninput="updatePreview()">
                            </div>
                            <div class="flex items-start gap-2 bg-gray-50 border border-gray-200 rounded-sm px-3 py-2.5">
                                <i class="ph ph-info text-brand-mediqo mt-0.5"></i>
                                <p class="text-xs text-gray-600">Embroidery will be placed on the left chest pocket area.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Preview Position -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="step-circle bg-brand-mediqo text-white">3</div>
                            <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm">Preview Position</h2>
                        </div>
                        <div class="flex gap-4 mb-4">
                            <div class="pos-card active border-2 rounded-lg p-3 cursor-pointer text-center w-36 relative transition-all" onclick="selectPos(this)">
                                <div class="pos-check absolute top-2 right-2 w-5 h-5 bg-brand-mediqo rounded-full items-center justify-center">
                                    <i class="ph-fill ph-check text-white text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center h-16 mb-2 text-gray-400">
                                    <svg viewBox="0 0 80 70" fill="none" stroke="currentColor" stroke-width="2.5" class="h-14 w-auto">
                                        <path d="M10,5 L0,20 L15,22 L15,65 L65,65 L65,22 L80,20 L70,5 L55,15 C55,15 50,20 40,20 C30,20 25,15 25,15 Z" stroke-linejoin="round"/>
                                        <rect x="16" y="26" width="12" height="9" rx="1" fill="#145c75" stroke="none"/>
                                    </svg>
                                </div>
                                <div class="text-xs font-bold text-brand-navy">Left Chest</div>
                                <div class="text-[0.6rem] text-gray-500">(Included)</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-2 bg-gray-50 border border-gray-200 rounded-sm px-3 py-2.5">
                            <i class="ph ph-check-circle text-brand-mediqo mt-0.5 text-sm"></i>
                            <p class="text-xs text-gray-600">Only left chest embroidery is available for MediQo scrubs.</p>
                        </div>
                    </div>
                </div>

                <!-- Column 4: Live Preview -->
                <div class="lg:w-[320px] shrink-0">
                    <div class="border border-gray-200 rounded-xl overflow-hidden sticky top-24 bg-white shadow-sm">
                        <div class="text-center py-3 text-[0.7rem] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-200 bg-gray-50/50">Live Preview</div>
                        
                        <!-- Preview image area with direct embroidery style -->
                        <div class="relative bg-[#3d0c18] h-[340px] overflow-hidden flex items-center justify-center">
                            <div class="absolute inset-0 opacity-20 bg-gradient-to-br from-[#5a1020] to-[#2a0a12]"></div>
                            <img src="https://placehold.co/320x380/7c1c2b/f8d5db?text=Zoomed+Chest+Area" alt="Live Preview" class="absolute inset-0 w-full h-full object-cover opacity-80">
                            
                            <!-- Direct embroidery overlay (White thread) -->
                            <div class="absolute top-[48%] left-[50%] -translate-x-1/2 -translate-y-1/2 text-center pointer-events-none select-none animate-fade-in" style="font-family: 'Outfit', sans-serif;">
                                <div class="text-white font-bold text-sm tracking-wide leading-tight" id="previewName">Dr. Priya S</div>
                                <div class="text-white/80 text-[0.65rem] tracking-wider leading-none mt-1" id="previewDesignation">Cardiology</div>
                            </div>
                        </div>
                        <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 flex items-start gap-2">
                            <i class="ph ph-info text-brand-mediqo text-sm mt-0.5 shrink-0"></i>
                            <p class="text-[0.65rem] text-gray-500 leading-relaxed">Preview is approximate. Actual embroidery may vary slightly.</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>


    @endif
@endsection

@section('scripts')
    @if ($type === 'corporate')
        <script>
            function selectEmb(el) {
                document.querySelectorAll('.emb-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }
            function selectPos(el) {
                document.querySelectorAll('.pos-card').forEach(c => {
                    c.classList.remove('active','border-brand-workon','bg-green-50');
                    c.classList.add('border-gray-200');
                });
                el.classList.add('active','border-brand-workon','bg-green-50');
                el.classList.remove('border-gray-200');
            }
            function updatePreview() {
                document.getElementById('previewName').textContent = document.getElementById('corpName').value || '';
                document.getElementById('previewDesig').textContent = document.getElementById('corpDesig').value || '';
            }
        </script>
    @elseif ($type === 'chef-coat')
        <script>
            function selectEmb(el) {
                document.querySelectorAll('.emb-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }
            function selectPos(el) {
                document.querySelectorAll('.pos-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }
            function updatePreview() {
                document.getElementById('previewName').textContent = document.getElementById('chefName').value || '';
                document.getElementById('previewDesig').textContent = document.getElementById('chefDesig').value || '';
            }
        </script>
    @else
        <script>
            function selectEmb(el) {
                document.querySelectorAll('.emb-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }
            function selectPos(el) {
                document.querySelectorAll('.pos-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }
            function updatePreview() {
                const name = document.getElementById('staffName').value || '';
                const designation = document.getElementById('designation').value || '';
                document.getElementById('previewName').textContent = name;
                document.getElementById('previewDesignation').textContent = designation;
            }
        </script>
    @endif
@endsection
