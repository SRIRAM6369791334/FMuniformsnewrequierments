@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-brand-mediqo">Home</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i> 
        <a href="{{ url('/categories/mediqo') }}" class="hover:text-brand-mediqo">MediQo</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
        <a href="{{ url('/shop') }}" class="hover:text-brand-mediqo">Scrubs</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i>
        <span class="text-gray-800 font-medium">Women's Scrub Set - Wine</span>
    </div>

    <!-- Main Product Section -->
    <main class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 mb-12">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <!-- Left: Images -->
            <div class="lg:w-1/2 flex gap-4">
                <!-- Thumbnails (Vertical) -->
                <div class="hidden md:flex flex-col gap-3 w-20 shrink-0">
                    <button class="border-2 border-brand-navy rounded-md overflow-hidden h-24 bg-brand-light flex items-center justify-center p-1">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Front" alt="Front View" class="h-full object-contain mix-blend-multiply">
                    </button>
                    <button class="border border-gray-200 hover:border-gray-400 rounded-md overflow-hidden h-24 bg-brand-light flex items-center justify-center p-1 transition-colors">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Back" alt="Back View" class="h-full object-contain mix-blend-multiply">
                    </button>
                    <button class="border border-gray-200 hover:border-gray-400 rounded-md overflow-hidden h-24 bg-brand-light flex items-center justify-center p-1 transition-colors">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Detail+1" alt="Pocket Detail" class="h-full object-contain mix-blend-multiply">
                    </button>
                    <button class="border border-gray-200 hover:border-gray-400 rounded-md overflow-hidden h-24 bg-brand-light flex items-center justify-center p-1 transition-colors">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Detail+2" alt="Pant Detail" class="h-full object-contain mix-blend-multiply">
                    </button>
                    <button class="border border-gray-200 hover:border-gray-400 rounded-md overflow-hidden h-24 bg-brand-light flex items-center justify-center p-1 transition-colors">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Fabric" alt="Fabric Detail" class="h-full object-contain mix-blend-multiply">
                    </button>
                    <button class="border border-gray-200 hover:border-brand-mediqo text-brand-mediqo rounded-md h-20 bg-gray-50 flex flex-col items-center justify-center transition-colors">
                        <i class="ph ph-play-circle text-2xl mb-1"></i>
                        <span class="text-[0.6rem] font-bold uppercase tracking-wide">Watch Video</span>
                    </button>
                </div>
                
                <!-- Main Image -->
                <div class="flex-1 bg-brand-light rounded-xl flex items-center justify-center relative min-h-[500px]">
                    <button class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 shadow-sm transition-colors">
                        <i class="ph ph-heart text-xl"></i>
                    </button>
                    <img src="https://placehold.co/600x800/f4f5f7/475569?text=Women's+Wine+Scrub" alt="Women's Scrub Set - Wine" class="h-full object-contain p-8 mix-blend-multiply max-h-[700px]">
                </div>
                
                <!-- Mobile Thumbnails (Horizontal) -->
                <div class="flex md:hidden overflow-x-auto gap-3 mt-4 pb-2 hide-scrollbar w-full">
                    <button class="border-2 border-brand-navy rounded-md overflow-hidden h-20 min-w-[5rem] bg-brand-light flex items-center justify-center p-1">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Front" alt="Front View" class="h-full object-contain">
                    </button>
                    <button class="border border-gray-200 rounded-md overflow-hidden h-20 min-w-[5rem] bg-brand-light flex items-center justify-center p-1">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Back" alt="Back View" class="h-full object-contain">
                    </button>
                     <button class="border border-gray-200 rounded-md overflow-hidden h-20 min-w-[5rem] bg-brand-light flex items-center justify-center p-1">
                        <img src="https://placehold.co/100x150/f4f5f7/475569?text=Detail" alt="Detail View" class="h-full object-contain">
                    </button>
                </div>
            </div>

            <!-- Right: Product Details -->
            <div class="lg:w-1/2 flex flex-col">
                <!-- Brand Logo -->
                <div class="flex items-center gap-1.5 text-brand-mediqo font-heading font-bold text-xl mb-1">
                    FM MEDIQO <i class="ph ph-activity text-lg"></i>
                </div>
                <div class="text-[0.55rem] text-brand-mediqo tracking-[0.2em] uppercase mb-4 font-semibold">— ENGINEERED FOR CARE —</div>
                
                <!-- Title & Rating -->
                <h1 class="text-3xl font-heading font-bold text-brand-navy mb-3">Women's Scrub Set - Wine</h1>
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center gap-1 text-yellow-500 text-sm">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                        <span class="text-gray-655 font-medium ml-1">4.7 <span class="text-gray-400 font-normal">(102 Reviews)</span></span>
                    </div>
                    <div class="w-px h-4 bg-gray-300"></div>
                    <div class="flex items-center gap-1 text-green-600 font-medium text-sm">
                        <i class="ph ph-check"></i> In Stock
                    </div>
                </div>

                <!-- Price -->
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-3xl font-heading font-extrabold text-brand-navy">₹1,499</span>
                    <span class="text-xs text-gray-500">Inclusive of all taxes</span>
                </div>

                <!-- Description -->
                <p class="text-gray-655 text-sm leading-relaxed mb-8 border-b border-gray-100 pb-8">
                    Premium quality women's scrub set designed for comfort, style and performance. Made with 4-way stretch fabric for all-day ease.
                </p>

                <!-- Color Selection -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-brand-navy uppercase tracking-wider">COLOR: <span class="font-normal text-gray-600 ml-1">Wine</span></span>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <!-- Teal -->
                        <div class="relative">
                            <input type="radio" name="color" id="color-teal" class="peer hidden color-radio">
                            <label for="color-teal" class="block w-8 h-8 rounded-full cursor-pointer bg-[#145c75] ring-2 ring-transparent ring-offset-2 hover:ring-gray-300 transition-all"></label>
                        </div>
                        <!-- Navy -->
                        <div class="relative">
                            <input type="radio" name="color" id="color-navy" class="peer hidden color-radio">
                            <label for="color-navy" class="block w-8 h-8 rounded-full cursor-pointer bg-[#0f172a] ring-2 ring-transparent ring-offset-2 hover:ring-gray-300 transition-all"></label>
                        </div>
                        <!-- Black -->
                        <div class="relative">
                            <input type="radio" name="color" id="color-black" class="peer hidden color-radio">
                            <label for="color-black" class="block w-8 h-8 rounded-full cursor-pointer bg-black ring-2 ring-transparent ring-offset-2 hover:ring-gray-300 transition-all"></label>
                        </div>
                        <!-- Grey -->
                        <div class="relative">
                            <input type="radio" name="color" id="color-grey" class="peer hidden color-radio">
                            <label for="color-grey" class="block w-8 h-8 rounded-full cursor-pointer bg-[#64748b] ring-2 ring-transparent ring-offset-2 hover:ring-gray-300 transition-all"></label>
                        </div>
                        <!-- Wine (Selected) -->
                        <div class="relative">
                            <input type="radio" name="color" id="color-wine" class="peer hidden color-radio" checked>
                            <label for="color-wine" class="block w-8 h-8 rounded-full cursor-pointer bg-[#7c1c2b] ring-2 ring-brand-navy ring-offset-2 transition-all transform scale-110 shadow-sm"></label>
                        </div>
                        <!-- Lavender -->
                        <div class="relative">
                            <input type="radio" name="color" id="color-lavender" class="peer hidden color-radio">
                            <label for="color-lavender" class="block w-8 h-8 rounded-full cursor-pointer bg-[#8b5cf6] ring-2 ring-transparent ring-offset-2 hover:ring-gray-300 transition-all"></label>
                        </div>
                    </div>
                </div>

                <!-- Size Selection -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-brand-navy uppercase tracking-wider">SIZE:</span>
                        <a href="#" class="text-xs text-brand-mediqo font-semibold flex items-center gap-1 hover:underline">
                            <i class="ph ph-ruler"></i> Size Guide
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <div class="relative">
                            <input type="radio" name="size" id="size-xxs" class="peer hidden">
                            <label for="size-xxs" class="block px-4 py-2 border border-gray-300 text-sm text-gray-700 cursor-pointer hover:border-gray-400 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm text-center min-w-[3rem]">XXS</label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="size" id="size-xs" class="peer hidden">
                            <label for="size-xs" class="block px-4 py-2 border border-gray-300 text-sm text-gray-700 cursor-pointer hover:border-gray-400 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm text-center min-w-[3rem]">XS</label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="size" id="size-s" class="peer hidden" checked>
                            <label for="size-s" class="block px-4 py-2 border border-brand-navy bg-brand-navy text-white text-sm cursor-pointer transition-colors rounded-sm text-center min-w-[3rem]">S</label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="size" id="size-m" class="peer hidden">
                            <label for="size-m" class="block px-4 py-2 border border-gray-300 text-sm text-gray-700 cursor-pointer hover:border-gray-400 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm text-center min-w-[3rem]">M</label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="size" id="size-l" class="peer hidden">
                            <label for="size-l" class="block px-4 py-2 border border-gray-300 text-sm text-gray-700 cursor-pointer hover:border-gray-400 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm text-center min-w-[3rem]">L</label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="size" id="size-xl" class="peer hidden">
                            <label for="size-xl" class="block px-4 py-2 border border-gray-300 text-sm text-gray-700 cursor-pointer hover:border-gray-400 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm text-center min-w-[3rem]">XL</label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="size" id="size-xxl" class="peer hidden">
                            <label for="size-xxl" class="block px-4 py-2 border border-gray-300 text-sm text-gray-700 cursor-pointer hover:border-gray-400 peer-checked:border-brand-navy peer-checked:bg-brand-navy peer-checked:text-white transition-colors rounded-sm text-center min-w-[3rem]">XXL</label>
                        </div>
                    </div>
                </div>

                <!-- Fit Selection -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-brand-navy uppercase tracking-wider">FIT:</span>
                    </div>
                    <div class="flex gap-3">
                        <div class="relative w-1/2 md:w-auto">
                            <input type="radio" name="fit" id="fit-regular" class="peer hidden" checked>
                            <label for="fit-regular" class="block px-6 py-2 border border-brand-navy text-brand-navy text-sm cursor-pointer transition-colors rounded-sm text-center font-medium bg-gray-50">Regular Fit</label>
                        </div>
                        <div class="relative w-1/2 md:w-auto">
                            <input type="radio" name="fit" id="fit-tailored" class="peer hidden">
                            <label for="fit-tailored" class="block px-6 py-2 border border-gray-300 text-gray-700 cursor-pointer hover:border-gray-400 transition-colors rounded-sm text-center">Tailored Fit</label>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-8 flex items-center gap-4">
                    <span class="text-xs font-bold text-brand-navy uppercase tracking-wider w-16">QUANTITY:</span>
                    <div class="flex items-center border border-gray-300 rounded-sm">
                        <button class="px-3 py-1.5 text-gray-500 hover:text-brand-navy hover:bg-gray-50 transition-colors"><i class="ph ph-minus text-sm"></i></button>
                        <input type="number" value="1" min="1" class="w-12 text-center text-sm font-semibold text-brand-navy focus:outline-none hide-scrollbar">
                        <button class="px-3 py-1.5 text-gray-500 hover:text-brand-navy hover:bg-gray-50 transition-colors"><i class="ph ph-plus text-sm"></i></button>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">( 238 Sets available )</span>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <a href="{{ url('/checkout') }}" class="bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-sm text-center transition-colors uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="ph ph-lightning"></i> BUY NOW
                    </a>
                    <a href="{{ url('/cart') }}" class="bg-brand-gold hover:bg-yellow-600 text-white font-bold text-sm py-3.5 rounded-sm text-center transition-colors uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="ph ph-shopping-cart"></i> ADD TO CART
                    </a>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <a href="{{ url('/shop') }}" class="border border-brand-mediqo text-brand-mediqo hover:bg-brand-mediqo hover:text-white font-bold text-xs py-3 rounded-sm transition-colors uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="ph ph-t-shirt"></i> CUSTOMIZE WITH LOGO
                    </a>
                    <a href="{{ url('/bulkorder') }}" class="border border-gray-300 text-gray-700 hover:border-brand-navy hover:text-brand-navy font-bold text-xs py-3 rounded-sm transition-colors uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="ph ph-users"></i> BULK ENQUIRY
                    </a>
                </div>
                
            </div>
        </div>
    </main>

    <!-- Benefits Bar -->
    <div class="border-y border-gray-200 bg-gray-50/50 mb-12">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="flex items-center gap-3 justify-center md:justify-start">
                    <i class="ph ph-intersect text-2xl text-gray-600"></i>
                    <div>
                        <div class="text-sm font-semibold text-brand-navy">Premium Fabric</div>
                        <div class="text-xs text-gray-500">4-Way Stretch</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center md:justify-start">
                    <i class="ph ph-arrow-counter-clockwise text-2xl text-gray-600"></i>
                    <div>
                        <div class="text-sm font-semibold text-brand-navy">Easy Returns</div>
                        <div class="text-xs text-gray-500">15 Days Return</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center md:justify-start">
                    <i class="ph ph-shield-check text-2xl text-gray-600"></i>
                    <div>
                        <div class="text-sm font-semibold text-brand-navy">Secure Payment</div>
                        <div class="text-xs text-gray-500">100% Secure</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center md:justify-start">
                    <i class="ph ph-buildings text-2xl text-gray-600"></i>
                    <div>
                        <div class="text-sm font-semibold text-brand-navy">Bulk Order Support</div>
                        <div class="text-xs text-gray-500">Special Pricing</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-center col-span-2 md:col-span-1 md:justify-start">
                    <i class="ph ph-truck text-2xl text-gray-600"></i>
                    <div>
                        <div class="text-sm font-semibold text-brand-navy">PAN India Delivery</div>
                        <div class="text-xs text-gray-500">Fast & Reliable</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs Section -->
    <section class="max-w-[1200px] mx-auto px-4 lg:px-8 mb-20">
        <!-- Tabs Header -->
        <div class="flex border-b border-gray-200 overflow-x-auto hide-scrollbar mb-8">
            <button class="px-6 py-3 font-bold text-sm tracking-wider uppercase text-brand-navy border-b-2 border-brand-navy whitespace-nowrap">PRODUCT DETAILS</button>
            <button class="px-6 py-3 font-semibold text-sm tracking-wider uppercase text-gray-555 hover:text-brand-navy whitespace-nowrap">FABRIC & CARE</button>
            <button class="px-6 py-3 font-semibold text-sm tracking-wider uppercase text-gray-555 hover:text-brand-navy whitespace-nowrap">SIZE & FIT</button>
            <button class="px-6 py-3 font-semibold text-sm tracking-wider uppercase text-gray-555 hover:text-brand-navy whitespace-nowrap">SHIPPING & RETURNS</button>
        </div>

        <!-- Tab Content (Product Details) -->
        <div class="grid md:grid-cols-3 gap-8 border border-gray-100 rounded-xl p-8 shadow-sm">
            
            <!-- Highlights -->
            <div>
                <h3 class="font-bold text-brand-navy mb-4">Product Highlights</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2 text-sm text-gray-600"><i class="ph ph-check text-brand-mediqo mt-0.5"></i> 4-Way Stretch fabric for maximum comfort</li>
                    <li class="flex items-start gap-2 text-sm text-gray-600"><i class="ph ph-check text-brand-mediqo mt-0.5"></i> Moisture-wicking & breathable</li>
                    <li class="flex items-start gap-2 text-sm text-gray-600"><i class="ph ph-check text-brand-mediqo mt-0.5"></i> Anti-wrinkle & fade resistant</li>
                    <li class="flex items-start gap-2 text-sm text-gray-600"><i class="ph ph-check text-brand-mediqo mt-0.5"></i> Soft on skin, perfect for long shifts</li>
                    <li class="flex items-start gap-2 text-sm text-gray-600"><i class="ph ph-check text-brand-mediqo mt-0.5"></i> 2 Spacious pockets in top</li>
                    <li class="flex items-start gap-2 text-sm text-gray-600"><i class="ph ph-check text-brand-mediqo mt-0.5"></i> 1 Back pocket in bottom with utility loop</li>
                </ul>
            </div>

            <!-- Set Includes -->
            <div class="flex flex-col items-center justify-center border-y md:border-y-0 md:border-x border-gray-100 py-6 md:py-0">
                <h3 class="font-bold text-xs text-gray-555 mb-6 uppercase tracking-wider">Set Includes</h3>
                <div class="flex gap-8 items-end">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 flex items-center justify-center opacity-60 mb-2">
                             <img src="https://placehold.co/100x100/ffffff/475569?text=Top+Sketch" alt="Top Sketch" class="h-full">
                        </div>
                        <span class="text-xs font-semibold text-brand-navy">V-Neck Top</span>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-32 flex items-center justify-center opacity-60 mb-2">
                            <img src="https://placehold.co/80x120/ffffff/475569?text=Pant+Sketch" alt="Pant Sketch" class="h-full">
                        </div>
                        <span class="text-xs font-semibold text-brand-navy">Pant</span>
                    </div>
                </div>
            </div>

            <!-- Fabric & Care Info -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="font-bold text-sm text-brand-navy mb-2">Fabric Composition:</h3>
                <p class="text-sm text-gray-600 mb-4">72% Polyester, 21% Viscose,<br>7% Spandex</p>
                
                <h3 class="font-bold text-sm text-brand-navy mb-2">Fabric Weight:</h3>
                <p class="text-sm text-gray-600 mb-6">180 GSM</p>

                <h3 class="font-bold text-sm text-brand-navy mb-4">Care Instructions:</h3>
                <div class="flex justify-between text-center gap-2">
                    <div class="flex flex-col items-center">
                        <i class="ph ph-drop text-2xl text-gray-600 mb-1"></i>
                        <span class="text-[0.6rem] text-gray-555 leading-tight">Machine Wash</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="ph ph-prohibit text-2xl text-gray-600 mb-1"></i>
                        <span class="text-[0.6rem] text-gray-555 leading-tight">Do Not Bleach</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="ph ph-circle-notch text-2xl text-gray-600 mb-1"></i>
                        <span class="text-[0.6rem] text-gray-555 leading-tight">Tumble Dry Low</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="ph ph-thermometer text-2xl text-gray-600 mb-1"></i>
                        <span class="text-[0.6rem] text-gray-555 leading-tight">Iron Low</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- You May Also Like Section -->
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-20">
        <h2 class="text-xl font-heading font-bold text-brand-navy tracking-widest uppercase text-center mb-10">YOU MAY ALSO LIKE</h2>
        
        <div class="flex overflow-x-auto hide-scrollbar gap-6 pb-4 relative">
            <!-- Suggestion 1 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[240px] lg:w-[calc(25%-1.2rem)]">
                <button class="absolute top-3 right-3 text-gray-300 hover:text-red-500 z-10 transition-colors"><i class="ph-fill ph-heart text-xl text-gray-300"></i></button>
                <div class="relative bg-gray-50 h-56 flex items-center justify-center p-2">
                    <img src="https://placehold.co/200x300/f8fafc/475569?text=Navy+Blue" alt="Navy Blue Scrub" class="h-full object-contain mix-blend-multiply">
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy text-sm">Women's Scrub Set</h3>
                    <p class="text-xs text-gray-500 mb-3">Navy Blue</p>
                    <div class="flex items-center justify-between mt-auto">
                        <div class="font-bold text-base text-brand-navy">₹1,499</div>
                        <div class="flex items-center gap-1 text-brand-gold text-xs">
                            <i class="ph-fill ph-star"></i><span class="text-gray-500 font-medium ml-0.5">4.6 (88)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suggestion 2 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[240px] lg:w-[calc(25%-1.2rem)]">
                <button class="absolute top-3 right-3 text-gray-300 hover:text-red-500 z-10 transition-colors"><i class="ph-fill ph-heart text-xl text-gray-300"></i></button>
                <div class="relative bg-gray-50 h-56 flex items-center justify-center p-2">
                    <img src="https://placehold.co/200x300/f8fafc/475569?text=Teal+Green" alt="Teal Green Scrub" class="h-full object-contain mix-blend-multiply">
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy text-sm">Women's Scrub Set</h3>
                    <p class="text-xs text-gray-500 mb-3">Teal Green</p>
                    <div class="flex items-center justify-between mt-auto">
                        <div class="font-bold text-base text-brand-navy">₹1,499</div>
                        <div class="flex items-center gap-1 text-brand-gold text-xs">
                            <i class="ph-fill ph-star"></i><span class="text-gray-500 font-medium ml-0.5">4.7 (96)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suggestion 3 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[240px] lg:w-[calc(25%-1.2rem)]">
                <button class="absolute top-3 right-3 text-gray-300 hover:text-red-500 z-10 transition-colors"><i class="ph-fill ph-heart text-xl text-gray-300"></i></button>
                <div class="relative bg-gray-50 h-56 flex items-center justify-center p-2">
                    <img src="https://placehold.co/200x300/f8fafc/475569?text=Lavender" alt="Lavender Scrub" class="h-full object-contain mix-blend-multiply">
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy text-sm">Women's Scrub Set</h3>
                    <p class="text-xs text-gray-500 mb-3">Lavender</p>
                    <div class="flex items-center justify-between mt-auto">
                        <div class="font-bold text-base text-brand-navy">₹1,499</div>
                        <div class="flex items-center gap-1 text-brand-gold text-xs">
                            <i class="ph-fill ph-star"></i><span class="text-gray-500 font-medium ml-0.5">4.6 (71)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suggestion 4 -->
            <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white shrink-0 w-[240px] lg:w-[calc(25%-1.2rem)]">
                <button class="absolute top-3 right-3 text-gray-300 hover:text-red-500 z-10 transition-colors"><i class="ph-fill ph-heart text-xl text-gray-300"></i></button>
                <div class="relative bg-gray-50 h-56 flex items-center justify-center p-2">
                    <img src="https://placehold.co/200x300/f8fafc/475569?text=Black" alt="Black Scrub" class="h-full object-contain mix-blend-multiply">
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-brand-navy text-sm">Women's Scrub Set</h3>
                    <p class="text-xs text-gray-500 mb-3">Black</p>
                    <div class="flex items-center justify-between mt-auto">
                        <div class="font-bold text-base text-brand-navy">₹1,499</div>
                        <div class="flex items-center gap-1 text-brand-gold text-xs">
                            <i class="ph-fill ph-star"></i><span class="text-gray-500 font-medium ml-0.5">4.6 (71)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Footer -->
    <div class="bg-[#0f4a5e] text-white py-6 border-b border-[#145c75]">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-[#145c75]">
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 rounded-full border border-[#1e7694] flex items-center justify-center text-xl"><i class="ph ph-buildings"></i></div>
                <div class="text-left">
                    <div class="text-sm font-bold">Trusted by 1000+</div>
                    <div class="text-[0.65rem] text-blue-100 uppercase tracking-wide">Hospitals & Clinics</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 rounded-full border border-[#1e7694] flex items-center justify-center text-xl"><i class="ph ph-heart"></i></div>
                <div class="text-left">
                    <div class="text-sm font-bold">Loved by 50,000+</div>
                    <div class="text-[0.65rem] text-blue-100 uppercase tracking-wide">Healthcare Professionals</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 rounded-full border border-[#1e7694] flex items-center justify-center text-xl"><i class="ph ph-shield-check"></i></div>
                <div class="text-left">
                    <div class="text-sm font-bold">Premium Quality</div>
                    <div class="text-[0.65rem] text-blue-100 uppercase tracking-wide">Crafted for Care</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 rounded-full border border-[#1e7694] flex items-center justify-center text-xl"><i class="ph ph-user"></i></div>
                <div class="text-left">
                    <div class="text-sm font-bold">Dedicated Support</div>
                    <div class="text-[0.65rem] text-blue-100 uppercase tracking-wide">We are here to help</div>
                </div>
            </div>
        </div>
    </div>
@endsection
