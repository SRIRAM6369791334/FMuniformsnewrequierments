<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $categoryId = $request->get('category');
        $subcategoryId = $request->get('subcategory');
        $search = $request->get('search');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sizeValue = $request->get('size_value');
        $colorValue = $request->get('color_value');
        $sortBy = $request->get('sort', 'created_at');
        // Default to newest first for created_at, but A-Z or Low-High for others
        $defaultOrder = ($sortBy === 'created_at') ? 'desc' : 'asc';
        $sortOrder = $request->get('order', $defaultOrder);

        // Only show products that have at least one variant
        $productsQuery = Product::has('variants')
            ->with(['category', 'subcategory']);

        // Optimized: Apply category filter using whereHas to avoid separate query
        if ($categoryId) {
            if (is_numeric($categoryId)) {
                $productsQuery->where('category_id', $categoryId);
            } else {
                $productsQuery->whereHas('category', function($q) use ($categoryId) {
                    $q->where('slug', $categoryId);
                });
            }
        }

        // Optimized: Apply subcategory filter using whereHas to avoid separate query
        if ($subcategoryId) {
            if (is_numeric($subcategoryId)) {
                $productsQuery->where('subcategory_id', $subcategoryId);
            } else {
                $productsQuery->whereHas('subcategory', function($q) use ($subcategoryId) {
                    $q->where('slug', $subcategoryId);
                });
            }
        }

        // Apply search filter
        if ($search) {
            $productsQuery->where('product_name', 'LIKE', '%' . $search . '%');
        }

        // Apply price range filter
        if ($minPrice !== null) {
            $productsQuery->where('product_regular_price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $productsQuery->where('product_regular_price', '<=', $maxPrice);
        }

        // Apply size value filter - check variants
        if ($sizeValue) {
            $productsQuery->whereHas('variants', function($query) use ($sizeValue) {
                $query->where('size_value', $sizeValue);
            });
        }

        // Apply color value filter - check variants
        if ($colorValue) {
            $productsQuery->whereHas('variants', function($query) use ($colorValue) {
                $query->where('color_value', $colorValue);
            });
        }

        // Apply sorting
        $allowedSortFields = ['product_name', 'product_regular_price', 'created_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            if ($sortBy === 'product_regular_price') {
                $subquery = ProductVariant::selectRaw('CAST(mrp_price AS DECIMAL(10,2))')
                    ->whereColumn('product_id', 'products.id');
                
                // If filters are active, sort by the filtered variant's price
                if ($sizeValue) {
                    $subquery->where('size_value', $sizeValue);
                }
                if ($colorValue) {
                    $subquery->where('color_value', $colorValue);
                }

                $subquery->orderByRaw("CASE
                    WHEN size_value = 'S' THEN 1
                    WHEN size_value = 'M' THEN 2
                    WHEN size_value = 'L' THEN 3
                    WHEN size_value = 'XL' THEN 4
                    WHEN size_value = 'XXL' THEN 5
                    ELSE 6 END")
                ->orderBy('id')
                ->limit(1);

                $productsQuery->orderBy($subquery, $sortOrder);
            } else {
                $productsQuery->orderBy($sortBy, $sortOrder);
            }
        }

        // Apply filters to eager loaded variants to ensure the displayed price matched the filter
        $productsQuery->with(['variants' => function($query) use ($sizeValue, $colorValue) {
            if ($sizeValue) {
                $query->where('size_value', $sizeValue);
            }
            if ($colorValue) {
                $query->where('color_value', $colorValue);
            }
            // Maintain original ordering
            $query->orderByRaw("CASE
                WHEN size_value = 'S' THEN 1
                WHEN size_value = 'M' THEN 2
                WHEN size_value = 'L' THEN 3
                WHEN size_value = 'XL' THEN 4
                WHEN size_value = 'XXL' THEN 5
                ELSE 6 END")
            ->orderBy('id');
        }]);

        // Get paginated products directly (no caching)
        $products = $productsQuery->paginate(12)->withQueryString();

        // Get categories directly (no caching)
        $categories = Category::with('subcategories')->withCount('products')->get();

        // Get size and color values directly (no caching)
        $sizeValues = ProductVariant::distinct('size_value')->whereNotNull('size_value')->pluck('size_value');
        $colorValues = ProductVariant::distinct('color_value')->whereNotNull('color_value')->pluck('color_value');

        // Get price range directly (no caching)
        $priceRange = [
            'min' => Product::min('product_regular_price') ?? 0,
            'max' => Product::max('product_regular_price') ?? 1000
        ];

        // Resolve slug to ID for active state in view
        if ($categoryId && !is_numeric($categoryId)) {
            $cat = Category::where('slug', $categoryId)->first();
            if ($cat) $categoryId = $cat->id;
        }
        if ($subcategoryId && !is_numeric($subcategoryId)) {
            $sub = Subcategory::where('slug', $subcategoryId)->first();
            if ($sub) $subcategoryId = $sub->id;
        }

        return view('pages.shop', compact(
            'products',
            'categories',
            'sizeValues',
            'colorValues',
            'priceRange',
            'categoryId',
            'subcategoryId',
            'search',
            'minPrice',
            'maxPrice',
            'sizeValue',
            'colorValue',
            'sortBy',
            'sortOrder'
        ));
    }

    public function show(Request $request, $slug)
    {
        // Initialize preSelectedVariantId
        $preSelectedVariantId = null;

        // Fetch product directly (no caching)
        $product = Product::with(['category', 'subcategory', 'variants' => function($query) {
            // Order variants by size priority: S, M, L, XL, then by ID
            $query->orderByRaw("CASE
                WHEN size_value = 'S' THEN 1
                WHEN size_value = 'M' THEN 2
                WHEN size_value = 'L' THEN 3
                WHEN size_value = 'XL' THEN 4
                WHEN size_value = 'XXL' THEN 5
                ELSE 6 END")
            ->orderBy('id');
        }, 'reviews.user', 'productChildImages'])->where('slug', $slug)->firstOrFail();

        // Get approved reviews for this product
        $reviews = $product->approvedReviews()->with('user')->orderBy('created_at', 'desc')->get();

        // Check if current user can review this product
        $canReview = false;
        $hasReviewed = false;
        if (auth()->check()) {
            $userId = auth()->id();
            // Check if user has purchased this product (only require payment, not delivery)
            $hasPurchased = \App\Models\ProductSlot::where('product_id', $product->id)
                ->whereHas('order', function($query) use ($userId) {
                    $query->where('user_id', $userId)
                          ->where('payment_status', 1) // paid
                          ->where('is_cancelled', 0); // not cancelled
                })
                ->exists();

            // Check if user already reviewed
            $hasReviewed = \App\Models\Review::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->exists();

            $canReview = $hasPurchased && !$hasReviewed;
        }

        // Get all unique size and color values for selectors
        $sizeValues = $product->variants->whereNotNull('size_value')
            ->pluck('size_value')
            ->unique()
            ->sort(function($a, $b) {
                $order = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4, 'XXL' => 5];
                return ($order[$a] ?? 99) - ($order[$b] ?? 99);
            })
            ->values();

        $colorValues = $product->variants->whereNotNull('color_value')
            ->pluck('color_value')
            ->unique()
            ->values();

        // Get variants for size and color selectors (one variant per unique size/color)
        $sizeVariants = collect();
        foreach($sizeValues as $size) {
            $variant = $product->variants->where('size_value', $size)->first();
            if($variant) {
                $sizeVariants->push($variant);
            }
        }

        $colorVariants = collect();
        foreach($colorValues as $color) {
            $variant = $product->variants->where('color_value', $color)->first();
            if($variant) {
                $colorVariants->push($variant);
            }
        }

        // Get all variant images for the slider
        $variantImages = $product->variants->pluck('variant_image')->filter()->unique()->values();

        // Get child images for thumbnails (separate from variant images)
        $childImages = $product->productChildImages->pluck('product_child_image')->filter()->values();

        return view('pages.product-detail', compact(
            'product',
            'sizeValues',
            'colorValues',
            'sizeVariants',
            'colorVariants',
            'variantImages',
            'childImages',
            'preSelectedVariantId',
            'reviews',
            'canReview',
            'hasReviewed'
        ));
    }
}
