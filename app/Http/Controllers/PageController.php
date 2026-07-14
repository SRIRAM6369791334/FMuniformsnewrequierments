<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\File;

/**
 * PageController - Handles static pages
 * 
 * Moved these from route closures to enable route caching (php artisan route:cache)
 * Route caching significantly improves route registration performance.
 */
class PageController extends Controller
{
    /**
     * About page
     */
    public function about()
    {
        $images = File::files(public_path('media/images/about'));
        $imageUrls = collect($images)->sortBy(function($file) {
            return $file->getFilename();
        })->map(function($file) {
            return 'media/images/about/' . $file->getFilename();
        })->toArray();

        // Get all categories with subcategories and product counts
        $categories = Category::with(['subcategories' => function($q) {
            $q->withCount('products');
        }])->get();

        $allCategories = $categories->flatMap(function($category) {
            return $category->subcategories->map(function($sub) use ($category) {
                return [
                    'name' => $sub->name,
                    'img' => $sub->image ? config('app.main_url') . $sub->image : null,
                    'category_slug' => $category->slug,
                    'subcategory_slug' => $sub->slug,
                    'product_count' => $sub->products_count
                ];
            });
        })->toArray();

        return view('pages.about', compact('imageUrls', 'allCategories'));
    }

    /**
     * Contact page
     */
    public function contact()
    {
        $isAuthenticated = auth()->check();
        $user = $isAuthenticated ? auth()->user() : null;
        $userJson = $isAuthenticated ? json_encode($user) : 'null';

        return view('pages.contact', compact('isAuthenticated', 'userJson'));
    }

    /**
     * Privacy policy page
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Terms and conditions page
     */
    public function termsConditions()
    {
        return view('pages.terms-conditions');
    }

    /**
     * Refund policy page
     */
    public function refundPolicy()
    {
        return view('pages.refund-policy');
    }

    /**
     * Bulk order page
     */
    public function bulkOrder()
    {
        // Get categories (consider caching this for performance)
        $categories = Category::with(['subcategories' => function($q) {
            $q->withCount('products');
        }])->get();

        $allCategories = $categories->flatMap(function($category) {
            return $category->subcategories->map(function($sub) use ($category) {
                return [
                    'name' => $sub->name,
                    'img' => $sub->image ? config('app.main_url') . $sub->image : null,
                    'category_slug' => $category->slug,
                    'subcategory_slug' => $sub->slug,
                    'product_count' => $sub->products_count
                ];
            });
        })->toArray();

        return view('pages.bulkorder', compact('allCategories'));
    }

    /**
     * Customize uniform page
     */
    public function customize()
    {
        return view('pages.customize');
    }
}
