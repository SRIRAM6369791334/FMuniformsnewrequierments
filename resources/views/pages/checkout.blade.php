@extends('layouts.app')

@section('content')
    <div class="max-w-[1200px] mx-auto px-4 py-10 lg:py-16">
        
        <div class="flex flex-col-reverse lg:flex-row gap-10">
            
            <!-- Left Column: Form Steps -->
            <div class="lg:w-3/5">
                
                <!-- Step 1: Contact -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-lg font-heading font-bold text-brand-navy flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-brand-navy text-white flex items-center justify-center text-xs">1</span> 
                            Contact Information
                        </h2>
                        <a href="{{ url('/login') }}" class="text-xs font-semibold text-brand-gold hover:underline">Log in</a>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <input type="email" placeholder="Email Address" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors" value="customer@example.com">
                        </div>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" class="rounded text-brand-navy focus:ring-brand-navy" checked>
                            Email me with news and offers
                        </label>
                    </div>
                </div>

                <!-- Step 2: Delivery -->
                <div class="bg-white rounded-xl shadow-[0_10px_30px_rgba(15,23,42,0.05)] border border-gray-200 overflow-hidden mb-6 relative">
                    <!-- Active Step Indicator Line -->
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-navy"></div>
                    
                    <div class="px-6 py-4 flex justify-between items-center pt-6">
                        <h2 class="text-lg font-heading font-bold text-brand-navy flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-brand-navy text-white flex items-center justify-center text-xs">2</span> 
                            Delivery Address
                        </h2>
                    </div>
                    <div class="p-6 pt-2">
                        <form class="space-y-4">
                            <div>
                                <select class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm bg-white transition-colors">
                                    <option>India</option>
                                    <option>United Arab Emirates</option>
                                    <option>Singapore</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="First Name" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                                <input type="text" placeholder="Last Name" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                            </div>
                            <input type="text" placeholder="Address" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                            <input type="text" placeholder="Apartment, suite, etc. (optional)" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                            <div class="grid grid-cols-3 gap-4">
                                <input type="text" placeholder="City" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                                <select class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm bg-white transition-colors">
                                    <option>Tamil Nadu</option>
                                    <option>Karnataka</option>
                                    <option>Kerala</option>
                                </select>
                                <input type="text" placeholder="PIN Code" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                            </div>
                            <input type="tel" placeholder="Phone" class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:border-brand-navy focus:ring-1 focus:ring-brand-navy text-sm transition-colors">
                            
                            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer pt-2">
                                <input type="checkbox" class="rounded text-brand-navy focus:ring-brand-navy">
                                Save this information for next time
                            </label>
                        </form>
                    </div>
                </div>

                <!-- Step 3: Payment -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                    <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-heading font-bold text-gray-400 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs">3</span> 
                            Payment
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-500 text-center py-4">Complete your details to continue to payment options.</p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-between">
                    <a href="{{ url('/cart') }}" class="text-sm font-semibold text-brand-navy hover:text-brand-gold transition-colors flex items-center gap-1">
                        <i class="ph ph-caret-left"></i> Return to cart
                    </a>
                    <button class="bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm px-8 py-4 rounded-md transition-all uppercase tracking-widest shadow-md">
                        Continue to Payment
                    </button>
                </div>
            </div>

            <!-- Right Column: Order Summary (Sticky) -->
            <div class="lg:w-2/5">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8 lg:sticky lg:top-24">
                    <h3 class="font-heading font-bold text-brand-navy text-lg mb-6 border-b border-gray-100 pb-4">Order Summary</h3>
                    
                    <!-- Items -->
                    <div class="space-y-4 mb-6">
                        <div class="flex gap-4">
                            <div class="relative">
                                <div class="w-16 h-16 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img src="https://placehold.co/200x200/e2e8f0/475569?text=Scrub" class="w-full h-full object-cover mix-blend-multiply">
                                </div>
                                <span class="absolute -top-2 -right-2 bg-gray-500 text-white text-[0.65rem] font-bold w-5 h-5 rounded-full flex items-center justify-center">2</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-brand-navy">Premium Scrub Top</h4>
                                <p class="text-xs text-gray-500">Color: Navy Blue</p>
                                <p class="text-xs text-gray-500">Size: M</p>
                            </div>
                            <div class="text-sm font-bold text-brand-navy">₹1,798</div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="relative">
                                <div class="w-16 h-16 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img src="https://placehold.co/200x200/e2e8f0/475569?text=Pant" class="w-full h-full object-cover mix-blend-multiply">
                                </div>
                                <span class="absolute -top-2 -right-2 bg-gray-500 text-white text-[0.65rem] font-bold w-5 h-5 rounded-full flex items-center justify-center">2</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-brand-navy">Classic Scrub Pant</h4>
                                <p class="text-xs text-gray-500">Color: Navy Blue</p>
                                <p class="text-xs text-gray-500">Size: M</p>
                            </div>
                            <div class="text-sm font-bold text-brand-navy">₹1,998</div>
                        </div>
                    </div>

                    <!-- Discount Code -->
                    <div class="flex gap-2 border-y border-gray-100 py-6 mb-6">
                        <input type="text" placeholder="Discount code" class="flex-1 border border-gray-300 px-4 py-2.5 rounded-md focus:outline-none focus:border-brand-navy text-sm uppercase">
                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold text-sm px-6 py-2.5 rounded-md transition-colors">
                            Apply
                        </button>
                    </div>

                    <!-- Totals -->
                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-brand-navy">₹3,796.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="text-gray-550 text-xs">Calculated at next step</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Taxes</span>
                            <span>₹683.28</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-200 pt-6">
                        <span class="text-base text-gray-800">Total</span>
                        <div class="flex items-end gap-2">
                            <span class="text-xs text-gray-500 mb-1">INR</span>
                            <span class="text-2xl font-heading font-extrabold text-brand-navy">₹4,479.28</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
