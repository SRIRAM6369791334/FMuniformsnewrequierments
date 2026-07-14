<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart and wishlist data with all views
        View::composer('*', function ($view) {
            $userId = Auth::id();
            $guestId = session('guest_user_id');

            // Optimized: Only load limited items for header preview (e.g., first 3 items)
            $cartQuery = Cart::with(['product.category', 'productVariant']);
            if ($userId) {
                $cartQuery->where('user_id', $userId);
            } elseif ($guestId) {
                $cartQuery->where('guest_user_id', $guestId)->whereNull('user_id');
            }
            $cartItems = $cartQuery->latest()->limit(3)->get();
            
            // Use optimized aggregation queries for totals
            $cartTotal = Cart::getCartTotal($userId, $guestId);
            $cartCount = Cart::getCartItemCount($userId, $guestId);

            // Optimized: Only get count for wishlist in header
            $wishlistQuery = Wishlist::whereHas('product');
            if ($userId) {
                $wishlistQuery->where('user_id', $userId);
            } elseif ($guestId) {
                // FALLBACK: Until wishlist table is migrated, we still use ip_address or add guest_user_id there too
                // For consistency, let's check if guest_user_id exists in wishlist or use session ID
                $wishlistQuery->where('ip_address', request()->ip())->whereNull('user_id');
            }
            $wishlistCount = $wishlistQuery->count();

            // Get categories with subcategories for dynamic mega menu
            $headerCategories = Category::with('subcategories')
                ->whereHas('subcategories')
                ->get();

            $view->with([
                'headerCartItems' => $cartItems,
                'headerCartTotal' => $cartTotal,
                'headerCartCount' => $cartCount,
                'headerWishlistCount' => $wishlistCount,
                'headerCategories' => $headerCategories
            ]);
        });
    }
}
