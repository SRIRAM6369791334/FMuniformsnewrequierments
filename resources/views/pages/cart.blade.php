@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
        <a href="{{ url('/') }}" class="hover:text-brand-mediqo">Home</a>
        <i class="ph ph-caret-right mx-1 text-[10px]"></i>
        <span class="text-gray-800 font-medium">Cart</span>
    </div>

    <!-- Page title + success toast -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 mb-6">
        <h1 class="text-2xl font-heading font-extrabold text-brand-navy mb-4">Your Cart <span class="text-gray-400 font-normal text-lg">(2 Items)</span></h1>
        <!-- Success Banner -->
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-sm px-4 py-3 text-green-700 text-sm">
            <i class="ph-fill ph-check-circle text-green-500 text-xl shrink-0"></i>
            <span>"Women's Scrub Set – Wine" added to cart successfully.</span>
        </div>
    </div>

    <!-- Cart Body -->
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 pb-20">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- ── LEFT: Cart Items ── -->
            <div class="flex-1">

                <!-- Table Header (Desktop) -->
                <div class="hidden md:grid grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-4 border-b border-gray-200 pb-3 mb-2 text-xs font-bold uppercase tracking-wider text-gray-500">
                    <div>Product</div>
                    <div class="text-center">Size</div>
                    <div class="text-center">Color</div>
                    <div class="text-center">Unit Price</div>
                    <div class="text-center">Quantity</div>
                </div>

                <!-- ── Cart Item 1 ── -->
                <div class="border border-gray-100 rounded-xl p-5 mb-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                        <!-- Thumbnail -->
                        <div class="w-20 h-24 shrink-0 bg-brand-light rounded-lg flex items-center justify-center overflow-hidden border border-gray-200">
                            <img src="https://placehold.co/80x110/f4f5f7/475569?text=Wine+Scrub" alt="Women's Scrub Set – Wine" class="h-full object-contain mix-blend-multiply p-1">
                        </div>
                        <!-- Info -->
                        <div class="flex-1">
                            <div class="font-bold text-base text-brand-navy mb-0.5">Women's Scrub Set – Wine</div>
                            <div class="text-xs text-gray-550 mb-0.5">Premium 4-Way Stretch Fabric</div>
                            <div class="text-xs text-gray-400 mb-2">Product Code: MED-SCR-WS-01</div>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">
                                <i class="ph-fill ph-check-circle text-sm"></i> In Stock
                            </span>
                        </div>
                        <!-- Size -->
                        <div class="md:w-16 text-center">
                            <div class="text-xs text-gray-400 mb-1 md:hidden">Size</div>
                            <span class="inline-block border border-gray-300 text-brand-navy font-semibold text-sm px-3 py-1 rounded-sm">S</span>
                        </div>
                        <!-- Color -->
                        <div class="md:w-20 text-center flex md:flex-col items-center gap-2 md:gap-1">
                            <div class="text-xs text-gray-400 md:hidden">Color</div>
                            <div class="w-5 h-5 rounded-full bg-[#7c1c2b] border border-gray-300 shadow-sm"></div>
                            <span class="text-xs text-gray-600 hidden md:block">Wine</span>
                        </div>
                        <!-- Unit Price -->
                        <div class="md:w-24 text-center">
                            <div class="text-xs text-gray-400 mb-1 md:hidden">Unit Price</div>
                            <div class="font-bold text-brand-navy">₹1,499</div>
                        </div>
                        <!-- Quantity & Total -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="flex items-center border border-gray-300 rounded-sm">
                                <button class="px-2.5 py-1.5 text-gray-500 hover:bg-gray-100 text-sm transition-colors" onclick="changeQty(this, -1)"><i class="ph ph-minus"></i></button>
                                <input type="number" value="1" min="1" class="w-10 text-center text-sm font-semibold text-brand-navy focus:outline-none">
                                <button class="px-2.5 py-1.5 text-gray-500 hover:bg-gray-100 text-sm transition-colors" onclick="changeQty(this, 1)"><i class="ph ph-plus"></i></button>
                            </div>
                        </div>
                        <!-- Total -->
                        <div class="md:w-20 text-right">
                            <div class="font-bold text-brand-navy">₹1,499</div>
                        </div>
                        <!-- Remove -->
                        <button class="text-xs text-red-400 hover:text-red-655 flex items-center gap-1 transition-colors shrink-0">
                            <i class="ph ph-trash"></i> Remove
                        </button>
                    </div>
                </div>

                <!-- ── Cart Item 2 ── -->
                <div class="border border-gray-100 rounded-xl p-5 mb-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                        <!-- Thumbnail -->
                        <div class="w-20 h-24 shrink-0 bg-brand-light rounded-lg flex items-center justify-center overflow-hidden border border-gray-200">
                            <img src="https://placehold.co/80x110/f4f5f7/475569?text=Navy+Scrub" alt="V-Neck Scrub Top – Navy Blue" class="h-full object-contain mix-blend-multiply p-1">
                        </div>
                        <!-- Info -->
                        <div class="flex-1">
                            <div class="font-bold text-base text-brand-navy mb-0.5">V-Neck Scrub Top – Navy Blue</div>
                            <div class="text-xs text-gray-550 mb-0.5">4-Way Stretch Fabric</div>
                            <div class="text-xs text-gray-400 mb-2">Product Code: MED-SCR-VN-02</div>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">
                                <i class="ph-fill ph-check-circle text-sm"></i> In Stock
                            </span>
                        </div>
                        <!-- Size -->
                        <div class="md:w-16 text-center">
                            <div class="text-xs text-gray-400 mb-1 md:hidden">Size</div>
                            <span class="inline-block border border-gray-300 text-brand-navy font-semibold text-sm px-3 py-1 rounded-sm">M</span>
                        </div>
                        <!-- Color -->
                        <div class="md:w-20 text-center flex md:flex-col items-center gap-2 md:gap-1">
                            <div class="text-xs text-gray-400 md:hidden">Color</div>
                            <div class="w-5 h-5 rounded-full bg-[#0f172a] border border-gray-300 shadow-sm"></div>
                            <span class="text-xs text-gray-600 hidden md:block">Navy Blue</span>
                        </div>
                        <!-- Unit Price -->
                        <div class="md:w-24 text-center">
                            <div class="text-xs text-gray-400 mb-1 md:hidden">Unit Price</div>
                            <div class="font-bold text-brand-navy">₹699</div>
                        </div>
                        <!-- Quantity -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="flex items-center border border-gray-300 rounded-sm">
                                <button class="px-2.5 py-1.5 text-gray-500 hover:bg-gray-100 text-sm transition-colors" onclick="changeQty(this, -1)"><i class="ph ph-minus"></i></button>
                                <input type="number" value="1" min="1" class="w-10 text-center text-sm font-semibold text-brand-navy focus:outline-none">
                                <button class="px-2.5 py-1.5 text-gray-500 hover:bg-gray-100 text-sm transition-colors" onclick="changeQty(this, 1)"><i class="ph ph-plus"></i></button>
                            </div>
                        </div>
                        <!-- Total -->
                        <div class="md:w-20 text-right">
                            <div class="font-bold text-brand-navy">₹699</div>
                        </div>
                        <!-- Remove -->
                        <button class="text-xs text-red-400 hover:text-red-655 flex items-center gap-1 transition-colors shrink-0">
                            <i class="ph ph-trash"></i> Remove
                        </button>
                    </div>
                </div>

                <!-- Cart Actions -->
                <div class="flex flex-col sm:flex-row justify-between gap-3">
                    <a href="{{ url('/shop') }}" class="border border-gray-300 hover:border-brand-navy text-gray-700 hover:text-brand-navy font-semibold text-sm px-5 py-2.5 rounded-sm transition-colors flex items-center gap-2 w-fit">
                        <i class="ph ph-arrow-left"></i> CONTINUE SHOPPING
                    </a>
                    <button class="border border-gray-300 hover:border-brand-navy text-gray-700 hover:text-brand-navy font-semibold text-sm px-5 py-2.5 rounded-sm transition-colors flex items-center gap-2 w-fit">
                        UPDATE CART <i class="ph ph-arrows-clockwise"></i>
                    </button>
                </div>

                <!-- You May Also Like -->
                <div class="mt-12">
                    <h2 class="font-heading font-bold text-brand-navy text-lg uppercase tracking-widest mb-6 text-center">You May Also Like</h2>
                    <div class="flex overflow-x-auto hide-scrollbar gap-4 pb-4 relative">
                        <!-- Product 1 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shrink-0 w-[190px] lg:w-[calc(25%-1rem)]">
                            <div class="h-44 bg-brand-light flex items-center justify-center p-2">
                                <img src="https://placehold.co/160x200/f4f5f7/475569?text=Teal+Set" alt="Unisex Scrub Set" class="h-full object-contain mix-blend-multiply">
                            </div>
                            <div class="p-3">
                                <div class="font-semibold text-xs text-brand-navy mb-0.5">Unisex Scrub Set – Teal Green</div>
                                <div class="flex items-center gap-1 text-yellow-500 text-xs mb-2">
                                    <i class="ph-fill ph-star"></i><span class="text-gray-400 text-[0.65rem] ml-0.5">4.7 (96)</span>
                                </div>
                                <div class="font-bold text-sm text-brand-navy mb-2">₹1,199</div>
                                <button class="w-full border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-[0.65rem] font-bold uppercase tracking-wide py-1.5 rounded-sm transition-colors">ADD TO CART</button>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shrink-0 w-[190px] lg:w-[calc(25%-1rem)]">
                            <div class="h-44 bg-brand-light flex items-center justify-center p-2">
                                <img src="https://placehold.co/160x200/f4f5f7/475569?text=Lavender+Set" alt="Women's Scrub Set - Lavender" class="h-full object-contain mix-blend-multiply">
                            </div>
                            <div class="p-3">
                                <div class="font-semibold text-xs text-brand-navy mb-0.5">Women's Scrub Set – Lavender</div>
                                <div class="flex items-center gap-1 text-yellow-500 text-xs mb-2">
                                    <i class="ph-fill ph-star"></i><span class="text-gray-400 text-[0.65rem] ml-0.5">4.6 (71)</span>
                                </div>
                                <div class="font-bold text-sm text-brand-navy mb-2">₹1,499</div>
                                <button class="w-full border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-[0.65rem] font-bold uppercase tracking-wide py-1.5 rounded-sm transition-colors">ADD TO CART</button>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shrink-0 w-[190px] lg:w-[calc(25%-1rem)]">
                            <div class="h-44 bg-brand-light flex items-center justify-center p-2">
                                <img src="https://placehold.co/160x200/f4f5f7/475569?text=Lab+Coat" alt="Lab Coat – Unisex" class="h-full object-contain mix-blend-multiply">
                            </div>
                            <div class="p-3">
                                <div class="font-semibold text-xs text-brand-navy mb-0.5">Lab Coat – Unisex</div>
                                <div class="flex items-center gap-1 text-yellow-500 text-xs mb-2">
                                    <i class="ph-fill ph-star"></i><span class="text-gray-400 text-[0.65rem] ml-0.5">4.8 (124)</span>
                                </div>
                                <div class="font-bold text-sm text-brand-navy mb-2">₹699</div>
                                <button class="w-full border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-[0.65rem] font-bold uppercase tracking-wide py-1.5 rounded-sm transition-colors">ADD TO CART</button>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shrink-0 w-[190px] lg:w-[calc(25%-1rem)]">
                            <div class="h-44 bg-brand-light flex items-center justify-center p-2">
                                <img src="https://placehold.co/160x200/f4f5f7/475569?text=Black+Set" alt="Premium Scrub Set – Black" class="h-full object-contain mix-blend-multiply">
                            </div>
                            <div class="p-3">
                                <div class="font-semibold text-xs text-brand-navy mb-0.5">Premium Scrub Set – Black</div>
                                <div class="flex items-center gap-1 text-yellow-500 text-xs mb-2">
                                    <i class="ph-fill ph-star"></i><span class="text-gray-400 text-[0.65rem] ml-0.5">4.8 (64)</span>
                                </div>
                                <div class="font-bold text-sm text-brand-navy mb-2">₹2,199</div>
                                <button class="w-full border border-gray-300 hover:border-brand-mediqo text-gray-700 hover:text-brand-mediqo text-[0.65rem] font-bold uppercase tracking-wide py-1.5 rounded-sm transition-colors">ADD TO CART</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── RIGHT: Order Summary ── -->
            <div class="lg:w-80 shrink-0">
                <div class="border border-gray-200 rounded-xl p-6 sticky top-24 shadow-sm bg-white">
                    <h2 class="font-heading font-bold text-brand-navy uppercase tracking-wider text-sm mb-6 pb-4 border-b border-gray-200">Order Summary</h2>

                    <div class="space-y-3 text-sm mb-4">
                        <div class="flex justify-between text-gray-655">
                            <span>Subtotal (2 Items)</span>
                            <span class="font-semibold text-brand-navy">₹2,198</span>
                        </div>
                        <div class="flex justify-between text-gray-655">
                            <span>Discount</span>
                            <span class="font-semibold text-green-600">- ₹220</span>
                        </div>
                        <div class="flex justify-between text-gray-655">
                            <span>Shipping</span>
                            <span class="font-semibold text-green-600">Free Delivery</span>
                        </div>
                        <div class="flex justify-between text-gray-655 pb-4 border-b border-gray-200">
                            <span>Tax (GST 12%)</span>
                            <span class="font-semibold text-brand-navy">₹237</span>
                        </div>
                        <div class="flex justify-between font-extrabold text-brand-navy text-base pt-1">
                            <span>Total Amount</span>
                            <span>₹2,215</span>
                        </div>
                        <p class="text-xs text-green-600 text-right font-medium">You save ₹220 on this order</p>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ url('/checkout') }}" class="w-full bg-brand-gold hover:bg-yellow-600 text-white font-bold py-3.5 rounded-sm transition-colors flex items-center justify-center gap-2 mb-3 text-sm uppercase tracking-wider">
                        PROCEED TO CHECKOUT <i class="ph ph-arrow-right"></i>
                    </a>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 text-gray-300 text-xs mb-3">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span>— OR —</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Buy Now -->
                    <a href="{{ url('/checkout') }}" class="w-full border border-brand-navy hover:bg-brand-navy hover:text-white text-brand-navy font-bold py-3 rounded-sm transition-colors flex items-center justify-center gap-2 mb-6 text-sm">
                        <i class="ph ph-lightning"></i> BUY NOW
                    </a>

                    <!-- Trust Indicators -->
                    <div class="space-y-4 border-t border-gray-100 pt-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-50 border border-green-200 rounded-full flex items-center justify-center shrink-0">
                                <i class="ph ph-shield-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-brand-navy">Secure Checkout</div>
                                <div class="text-xs text-gray-500">100% secure payments. Your data is safe with us.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-50 border border-blue-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="ph ph-arrow-counter-clockwise text-brand-mediqo text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-brand-navy">Easy Returns</div>
                                <div class="text-xs text-gray-500">15 days easy return & exchange</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-yellow-50 border border-yellow-200 rounded-full flex items-center justify-center shrink-0">
                                <i class="ph ph-star text-yellow-500 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-brand-navy">100% Original</div>
                                <div class="text-xs text-gray-500">Premium quality medical uniforms</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Trust Strip -->
    <div class="border-t border-gray-200 bg-gray-50 py-6">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
            <div class="flex items-center justify-center gap-3">
                <i class="ph ph-intersect text-xl text-gray-500"></i>
                <div class="text-left">
                    <div class="text-xs font-bold text-brand-navy">Premium Quality</div>
                    <div class="text-[0.6rem] text-gray-500">Crafted for comfort & durability</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <i class="ph ph-arrow-counter-clockwise text-xl text-gray-500"></i>
                <div class="text-left">
                    <div class="text-xs font-bold text-brand-navy">Easy Returns</div>
                    <div class="text-[0.6rem] text-gray-500">15 days return policy</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <i class="ph ph-shield-check text-xl text-gray-500"></i>
                <div class="text-left">
                    <div class="text-xs font-bold text-brand-navy">Secure Payment</div>
                    <div class="text-[0.6rem] text-gray-500">100% safe & secure</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <i class="ph ph-truck text-xl text-gray-500"></i>
                <div class="text-left">
                    <div class="text-xs font-bold text-brand-navy">PAN India Delivery</div>
                    <div class="text-[0.6rem] text-gray-500">Fast & reliable delivery</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3 col-span-2 md:col-span-1">
                <i class="ph ph-buildings text-xl text-gray-500"></i>
                <div class="text-left">
                    <div class="text-xs font-bold text-brand-navy">Bulk Order Support</div>
                    <div class="text-[0.6rem] text-gray-500">Special pricing for institutions</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function changeQty(btn, delta) {
            const input = btn.parentElement.querySelector('input');
            const newVal = Math.max(1, parseInt(input.value) + delta);
            input.value = newVal;
        }
    </script>
@endsection
