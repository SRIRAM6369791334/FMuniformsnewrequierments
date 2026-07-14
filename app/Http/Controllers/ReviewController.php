<?php

namespace App\Http\Controllers;

use App\Models\ProductSlot;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to submit a review.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'subject' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        // Check if user has purchased this product
        $hasPurchased = ProductSlot::where('product_id', $productId)
            ->whereHas('order', function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('payment_status', 1) // paid
                      ->where('is_cancelled', 0); // not cancelled
            })
            ->exists();

        if (!$hasPurchased) {
            return response()->json([
                'success' => false,
                'message' => 'You can only review products you have purchased and received.'
            ], 403);
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.'
            ], 409);
        }

        // Get the order_id for the review (use the most recent paid order for this product)
        $productSlot = ProductSlot::where('product_id', $productId)
            ->whereHas('order', function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('payment_status', 1) // paid
                      ->where('is_cancelled', 0); // not cancelled
            })
            ->with('order')
            ->orderBy('created_at', 'desc') // Get the most recent order
            ->first();

        if (!$productSlot || !$productSlot->order) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to find your order for this product.'
            ], 404);
        }

        // Create the review
        $review = Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'order_id' => $productSlot->order->id,
            'subject' => $request->subject,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Reviews start as pending approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Submitted',
            'review' => $review
        ]);
    }
}
