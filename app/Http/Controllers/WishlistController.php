<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $userId = Auth::id();
        $ipAddress = $this->getClientIp();

        $wishlistItems = Wishlist::getUserWishlist($userId, $ipAddress);

        return view('pages.wishlist', compact('wishlistItems'));
    }

    /**
     * Add item to wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_varient,id',
        ]);

        $userId = Auth::id();
        $ipAddress = $this->getClientIp();

        // Check if item already exists in wishlist
        if (Wishlist::isInWishlist($request->product_id, $request->product_variant_id, $userId, $ipAddress)) {
            return response()->json([
                'success' => false
            ], 400);
        }

        Wishlist::create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item added to wishlist'
        ]);
    }

    /**
     * Remove item from wishlist
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $ipAddress = $this->getClientIp();

        $wishlistItem = Wishlist::find($id);

        if (!$wishlistItem) {
            return response()->json([
                'success' => true,
                'message' => 'Item already removed'
            ]);
        }

        // Check if user owns this wishlist item
        if ($userId && $wishlistItem->user_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // For guest users, check IP address
        if (!$userId && $wishlistItem->ip_address !== $ipAddress) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist'
        ]);
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_varient,id',
        ]);

        $userId = Auth::id();
        $ipAddress = $this->getClientIp();

        $isInWishlist = Wishlist::isInWishlist($request->product_id, $request->product_variant_id, $userId, $ipAddress);

        return response()->json([
            'in_wishlist' => $isInWishlist
        ]);
    }

    /**
     * Transfer guest wishlist to user account (called after login)
     */
    public function transfer()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $userId = Auth::id();
        $ipAddress = $this->getClientIp();

        $transferredCount = Wishlist::transferGuestWishlist($ipAddress, $userId);

        return response()->json([
            'success' => true,
            'message' => "Transferred {$transferredCount} items from guest wishlist",
            'transferred_count' => $transferredCount
        ]);
    }

    /**
     * Get client IP address
     */
    private function getClientIp()
    {
        return request()->ip();
    }
}
