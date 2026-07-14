@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-brand-mediqo">Home</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i> 
        <a href="{{ url('/categories/mediqo') }}" class="hover:text-brand-mediqo">MediQo</a> <i class="ph ph-caret-right mx-1 text-[10px]"></i> 
        <span class="text-gray-800 font-medium">Scrubs</span>
    </div>

    <!-- Collection Divider -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-8 flex items-center justify-center gap-4">
        <div class="h-px bg-gray-300 w-full max-w-[200px]"></div>
        <i class="ph ph-activity text-brand-mediqo text-xl"></i>
        <h2 class="font-heading font-bold text-lg text-brand-navy uppercase tracking-widest whitespace-nowrap">ALL SCRUBS COLLECTION</h2>
        <i class="ph ph-activity text-brand-mediqo text-xl"></i>
        <div class="h-px bg-gray-300 w-full max-w-[200px]"></div>
    </div>

    <!-- Main Content: Sidebar + Grid -->
    <main class="max-w-[1600px] mx-auto px-4 lg:px-8 pb-16 flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 shrink-0 hidden lg:block border-r border-gray-200 pr-6">
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-gray-200">
                <h3 class="font-bold text-sm tracking-wide">FILTERS</h3>
                <a href="{{ url('/shop') }}" class="text-xs text-gray-500 hover:text-brand-navy underline">CLEAR ALL</a>
            </div>

            <!-- Categories -->
            <div class="mb-6">
                <h4 class="font-bold text-xs uppercase tracking-wide mb-3 text-gray-700">CATEGORIES</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="bg-brand-hero text-brand-mediqo font-semibold px-3 py-1.5 rounded-sm -mx-3">Scrubs</li>
                    <li class="px-3 py-1.5 hover:text-brand-mediqo cursor-pointer transition-colors">Scrub Sets</li>
                    <li class="px-3 py-1.5 hover:text-brand-mediqo cursor-pointer transition-colors">Scrub Tops</li>
                    <li class="px-3 py-1.5 hover:text-brand-mediqo cursor-pointer transition-colors">Scrub Bottoms</li>
                </ul>
            </div>

            <!-- Gender -->
            <div class="mb-6 border-t border-gray-100 pt-4">
                <h4 class="font-bold text-xs uppercase tracking-wide mb-3 text-gray-700">GENDER</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Men</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Women</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Unisex</label>
                </div>
            </div>

            <!-- Color -->
            <div class="mb-6 border-t border-gray-100 pt-4">
                <h4 class="font-bold text-xs uppercase tracking-wide mb-3 text-gray-700">COLOR</h4>
                <div class="flex flex-wrap gap-2">
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-[#145c75]"></div></label>
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-[#0f172a]"></div></label>
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-[#52525b]"></div></label>
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-[#7c1c2b]"></div></label>
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-[#0369a1]"></div></label>
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-[#8b5cf6]"></div></label>
                    <label class="color-swatch cursor-pointer"><input type="radio" name="color" class="hidden"><div class="w-6 h-6 rounded-full bg-white border border-gray-300"></div></label>
                </div>
                <button class="text-xs text-gray-500 mt-2 hover:text-brand-navy">+ View More</button>
            </div>

            <!-- Size -->
            <div class="mb-6 border-t border-gray-100 pt-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-bold text-xs uppercase tracking-wide text-gray-700">SIZE</h4>
                    <button class="text-[10px] font-bold text-brand-mediqo uppercase tracking-wide">Size Guide</button>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> XS</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> XL</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> S</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> XXL</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> M</label>
                    <label class="flex items-center gap-2 cursor-pointer text-gray-400"><input type="checkbox" disabled class="rounded text-brand-mediqo focus:ring-brand-mediqo"> 3XL</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> L</label>
                    <label class="flex items-center gap-2 cursor-pointer text-gray-400"><input type="checkbox" disabled class="rounded text-brand-mediqo focus:ring-brand-mediqo"> 4XL</label>
                </div>
            </div>

            <!-- Fabric -->
            <div class="mb-6 border-t border-gray-100 pt-4">
                <h4 class="font-bold text-xs uppercase tracking-wide mb-3 text-gray-700">FABRIC</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Cotton</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Polyester</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Cotton Rich</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> 4-Way Stretch</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded text-brand-mediqo focus:ring-brand-mediqo"> Antimicrobial</label>
                </div>
            </div>

            <!-- Price -->
            <div class="mb-6 border-t border-gray-100 pt-4">
                <h4 class="font-bold text-xs uppercase tracking-wide mb-3 text-gray-700">PRICE</h4>
                <input type="range" min="0" max="3000" class="w-full accent-brand-mediqo mb-2">
                <div class="flex justify-between text-xs text-gray-600 font-medium">
                    <span>₹0</span>
                    <span>₹3,000+</span>
                </div>
            </div>
        </aside>

        <!-- Product Grid Area -->
        <div class="flex-1">
            
            <!-- Grid Top Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 pb-4 border-b border-gray-200 gap-4">
                <div class="text-sm text-gray-500">Showing 1-12 of 128 Products</div>
                <div class="flex items-center gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500">Sort By:</span>
                        <select class="border border-gray-300 rounded px-2 py-1 text-gray-700 focus:outline-none">
                            <option>Popular</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest Arrivals</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 text-gray-500 border-l border-gray-300 pl-4">
                        <span>View:</span>
                        <div class="inline-flex items-center rounded-md border border-gray-300 overflow-hidden bg-white">
                            <button id="gridViewBtn" type="button" class="w-9 h-9 flex items-center justify-center text-brand-navy bg-white hover:bg-gray-50" aria-label="Grid view">
                                <i class="ph ph-squares-four text-xl"></i>
                            </button>
                            <button id="listViewBtn" type="button" class="w-9 h-9 flex items-center justify-center text-gray-500 bg-white hover:text-gray-800 hover:bg-gray-50" aria-label="List view">
                                <i class="ph ph-list-dashes text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="shop-product-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <!-- Product Card 1 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <!-- Badges & Wishlist -->
                    <div class="absolute top-3 left-3 bg-brand-navy text-white text-[0.6rem] font-bold px-2 py-1 rounded-sm uppercase tracking-widest z-10">BEST SELLER</div>
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <!-- Image -->
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=V-Neck+Scrub+Top" alt="V-Neck Scrub Top" class="h-full object-contain mix-blend-multiply">
                        <!-- Color Dots Overlay -->
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                            <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#7c1c2b] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-white border border-gray-300"></div>
                        </div>
                    </div>
                    <!-- Details -->
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">V-Neck Scrub Top</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-550 font-medium ml-1">4.8 (124)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹699</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> 4-Way Stretch</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Regular Fit</div>
                        
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/v-neck-scrub-top') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <div class="absolute top-3 left-3 bg-brand-mediqo text-white text-[0.6rem] font-bold px-2 py-1 rounded-sm uppercase tracking-widest z-10">NEW ARRIVAL</div>
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=Unisex+Scrub+Set" alt="Unisex Scrub Set" class="h-full object-contain mix-blend-multiply">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                            <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#52525b] border border-gray-300"></div>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Unisex Scrub Set</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-550 font-medium ml-1">4.7 (96)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹1,199</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> Premium Poly-Blend</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Regular Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/unisex-scrub-set') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=V-Neck+Scrub+Set" alt="V-Neck Scrub Set" class="h-full object-contain mix-blend-multiply">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                            <div class="w-3 h-3 rounded-full bg-[#93c5fd] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#7c1c2b] border border-gray-300"></div>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">V-Neck Scrub Set</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-555 font-medium ml-1">4.8 (86)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹1,499</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> Cotton Rich</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Regular Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/v-neck-scrub-set') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=Women's+Scrub+Set" alt="Women's Scrub Set" class="h-full object-contain mix-blend-multiply">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col gap-1.5 bg-white/80 p-1 rounded-full backdrop-blur-sm">
                            <div class="w-3 h-3 rounded-full bg-[#7c1c2b] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#145c75] border border-gray-300"></div>
                            <div class="w-3 h-3 rounded-full bg-[#0f172a] border border-gray-300"></div>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Women's Scrub Set</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-555 font-medium ml-1">4.7 (102)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹1,499</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> 4-Way Stretch</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Tailored Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/womens-scrub-set') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 5 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=Stretch+Scrub+Top" alt="Stretch Scrub Top" class="h-full object-contain mix-blend-multiply">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Stretch Scrub Top</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-555 font-medium ml-1">4.6 (78)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹799</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> 4-Way Stretch</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Regular Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/stretch-scrub-top') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 6 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=Women's+V-Neck" alt="Women's V-Neck Top" class="h-full object-contain mix-blend-multiply">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Women's V-Neck Top</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-555 font-medium ml-1">4.6 (71)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹699</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> Premium Poly-Blend</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Tailored Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/womens-v-neck-top') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 7 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=Premium+Scrub+Set" alt="Premium Scrub Set" class="h-full object-contain mix-blend-multiply">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Premium Scrub Set</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-555 font-medium ml-1">4.8 (64)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹2,199</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> 4-Way Stretch</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Regular Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/premium-scrub-set') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Product Card 8 -->
                <div class="product-card border border-gray-200 rounded-lg overflow-hidden flex flex-col group transition-all bg-white relative">
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 transition-colors"><i class="ph ph-heart text-xl"></i></button>
                    <div class="relative bg-brand-light h-64 flex items-center justify-center p-4">
                        <img src="https://placehold.co/300x400/f4f5f7/475569?text=Zipper+Scrub+Top" alt="Zipper Scrub Top" class="h-full object-contain mix-blend-multiply">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-brand-navy mb-1 text-sm truncate">Zipper Scrub Top</h3>
                        <div class="flex items-center gap-1 text-brand-gold text-xs mb-2">
                            <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                            <span class="text-gray-555 font-medium ml-1">4.5 (58)</span>
                        </div>
                        <div class="font-bold text-lg text-brand-navy mb-3">₹899</div>
                        <div class="text-[0.65rem] text-gray-600 mb-1"><span class="font-semibold text-gray-800">Fabric:</span> Cotton Rich</div>
                        <div class="text-[0.65rem] text-gray-600 mb-4"><span class="font-semibold text-gray-800">Fit:</span> Tailored Fit</div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ url('/product-detail/zipper-scrub-top') }}" class="flex-1 text-center border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-xs font-bold uppercase tracking-wide py-2 rounded-sm transition-colors block">VIEW DETAILS</a>
                            <a href="{{ url('/cart') }}" class="border border-gray-300 hover:bg-brand-mediqo hover:border-brand-mediqo hover:text-white text-gray-700 px-3 rounded-sm transition-colors flex items-center justify-center"><i class="ph ph-shopping-cart text-lg"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center mt-12 gap-2 text-sm">
                <button class="w-8 h-8 flex items-center justify-center rounded text-gray-400 hover:text-gray-800"><i class="ph ph-caret-left"></i></button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-brand-navy text-white font-medium">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 font-medium">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 font-medium">3</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 font-medium">4</button>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 font-medium">5</button>
                <span class="w-8 h-8 flex items-center justify-center text-gray-400">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 font-medium">11</button>
                <button class="w-8 h-8 flex items-center justify-center rounded text-gray-800 hover:bg-gray-100"><i class="ph ph-caret-right"></i></button>
            </div>

        </div>
    </main>

    <!-- Trust Features Banner -->
    <section class="border-t border-gray-200 py-8 bg-gray-50">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 flex flex-wrap justify-center md:justify-between gap-6">
            <div class="flex items-center gap-3">
                <i class="ph ph-t-shirt text-3xl text-brand-mediqo"></i>
                <div>
                    <div class="font-bold text-sm text-brand-navy">Premium Fabric</div>
                    <div class="text-[0.65rem] text-gray-500">High quality fabrics for<br>all day comfort.</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <i class="ph ph-arrows-left-right text-3xl text-brand-mediqo"></i>
                <div>
                    <div class="font-bold text-sm text-brand-navy">Easy Returns</div>
                    <div class="text-[0.65rem] text-gray-500">15 days easy<br>return policy.</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <i class="ph ph-shield-check text-3xl text-brand-mediqo"></i>
                <div>
                    <div class="font-bold text-sm text-brand-navy">Secure Payment</div>
                    <div class="text-[0.65rem] text-gray-500">100% secure payment<br>options.</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <i class="ph ph-buildings text-3xl text-brand-mediqo"></i>
                <div>
                    <div class="font-bold text-sm text-brand-navy">Bulk Order Support</div>
                    <div class="text-[0.65rem] text-gray-500">Special pricing for hospitals,<br>clinics & institutions.</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <i class="ph ph-truck text-3xl text-brand-mediqo"></i>
                <div>
                    <div class="font-bold text-sm text-brand-navy">PAN India Delivery</div>
                    <div class="text-[0.65rem] text-gray-500">Fast & reliable delivery<br>across India.</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        const productGrid = document.querySelector('.shop-product-grid');

        if (!gridBtn || !listBtn || !productGrid) {
            return;
        }

        function setActiveButton(activeBtn, inactiveBtn) {
            activeBtn.classList.remove('text-gray-500');
            activeBtn.classList.add('text-brand-navy');
            inactiveBtn.classList.remove('text-brand-navy');
            inactiveBtn.classList.add('text-gray-500');
        }

        function setView(view) {
            if (view === 'grid') {
                productGrid.classList.remove('grid-cols-1');
                productGrid.classList.add('sm:grid-cols-2', 'md:grid-cols-3', 'xl:grid-cols-4');
                productGrid.querySelectorAll('.product-card').forEach(card => {
                    card.classList.remove('md:flex-row');
                    card.classList.remove('items-center');
                });
                setActiveButton(gridBtn, listBtn);
            } else {
                productGrid.classList.add('grid-cols-1');
                productGrid.classList.remove('sm:grid-cols-2', 'md:grid-cols-3', 'xl:grid-cols-4');
                productGrid.querySelectorAll('.product-card').forEach(card => {
                    card.classList.add('md:flex-row', 'items-center');
                });
                setActiveButton(listBtn, gridBtn);
            }
        }

        gridBtn.addEventListener('click', function () {
            setView('grid');
        });

        listBtn.addEventListener('click', function () {
            setView('list');
        });

        setView('grid');
    });
</script>
@endsection