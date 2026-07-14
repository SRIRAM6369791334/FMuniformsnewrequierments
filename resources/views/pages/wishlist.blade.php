@extends('layouts.app')

@section('content')
    <!-- Breadcrumb & Hero -->
    <div class="bg-gray-50 border-b border-gray-200 py-12">
        <div class="max-w-[1200px] mx-auto px-4 text-center">
            <div class="text-xs text-gray-500 mb-3">
                <a href="{{ url('/') }}" class="hover:text-brand-navy transition-colors">Home</a> <span class="mx-1">/</span> <span class="text-gray-800 font-medium">Wishlist</span>
            </div>
            <h1 class="text-4xl font-heading font-extrabold text-brand-navy tracking-tight">My Wishlist</h1>
            <p class="text-gray-550 text-sm mt-2">Saved items that you love.</p>
        </div>
    </div>

    <!-- Wishlist Section -->
    <section class="max-w-[1200px] mx-auto px-4 py-16">
        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($wishlistItems as $wishlistItem)
                    @php
                        $firstVariant = $wishlistItem->product->variants->first();
                    @endphp
                    <div class="product-card border border-gray-200 rounded-xl overflow-hidden flex flex-col group transition-all bg-white relative hover:shadow-md hover:border-brand-navy duration-300">
                        <!-- Remove button -->
                        <button class="absolute top-4 right-4 text-red-500 hover:text-red-700 z-10 transition-colors remove-wishlist" data-wishlist-id="{{ $wishlistItem->id }}" data-product-id="{{ $wishlistItem->product_id }}">
                            <i class="ph-fill ph-heart text-2xl"></i>
                        </button>
                        
                        <!-- Product Image -->
                        <div class="relative bg-brand-light aspect-[4/5] flex items-center justify-center p-4">
                            <img src="{{ $firstVariant && $firstVariant->variant_image ? config('app.main_url') . $firstVariant->variant_image : ($wishlistItem->product->product_image ? config('app.main_url') . $wishlistItem->product->product_image : config('app.main_url') . '/media/images/product/sp1.jpg') }}" alt="{{ $wishlistItem->product->product_name }}" class="h-full object-contain mix-blend-multiply">
                        </div>

                        <!-- Product Info -->
                        <div class="p-5 flex flex-col flex-1">
                            <span class="text-brand-gold text-[10px] font-bold uppercase tracking-wider mb-1">{{ $wishlistItem->product->category->name ?? 'Category' }}</span>
                            <h3 class="font-heading font-bold text-brand-navy text-sm mb-2 hover:text-brand-gold transition-colors">
                                <a href="{{ route('product.detail', ['slug' => $wishlistItem->product->slug]) }}">{{ $wishlistItem->product->product_name }}</a>
                            </h3>
                            
                            @if($wishlistItem->product->variants->count() > 0)
                                <div class="text-[11px] text-gray-500 font-semibold mb-3">
                                    Sizes: {{ $wishlistItem->product->variants->pluck('size_value')->filter()->unique()->implode(', ') }}
                                </div>
                            @endif

                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                <span class="font-heading font-extrabold text-brand-navy text-base">₹{{ number_format($firstVariant ? $firstVariant->variant_price : $wishlistItem->product->product_price, 2) }}</span>
                                <a href="#" class="cart-btn bg-brand-navy hover:bg-gray-800 text-white font-bold text-[10px] px-4 py-2 rounded uppercase tracking-wider transition-colors" 
                                   data-product-id="{{ $wishlistItem->product_id }}" 
                                   data-first-variant-id="{{ $firstVariant ? $firstVariant->id : '' }}" 
                                   data-stock="{{ $firstVariant ? $firstVariant->variant_quantity : $wishlistItem->product->product_quantity }}">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    <i class="ph ph-heart-break"></i>
                </div>
                <h2 class="text-2xl font-heading font-bold text-brand-navy mb-2">Your Wishlist is Empty</h2>
                <p class="text-gray-550 text-sm mb-8">Add items to your wishlist from the shop page to save them here.</p>
                <a href="{{ route('shop') }}" class="bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm px-8 py-4 rounded-md transition-all uppercase tracking-widest shadow-md">
                    Continue Shopping
                </a>
            </div>
        @endif
    </section>
@endsection
