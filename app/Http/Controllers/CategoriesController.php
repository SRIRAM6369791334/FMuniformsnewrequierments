<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
    public function index($slug = null)
    {
        $filter = request('filter');

        // If a slug is provided, find the category and use its ID as the filter
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $filter = $category->id;
            }
        }

        // Get categories directly (no caching)
        $categories = Category::with(['subcategories' => function($q) {
            $q->withCount('products');
        }])->get();

        // Build category mappings for JavaScript filtering using IDs
        $categoryMappings = $categories->mapWithKeys(function($category) {
            return [$category->id => $category->subcategories->pluck('id')->toArray()];
        })->toArray();

        // Convert subcategories to array format for Blade template (single transformation)
        $allCategories = $categories->flatMap(function($category) use ($filter) {
            // Apply server-side filtering for initial page load
            if ($filter && $filter !== 'all' && $category->id != $filter) {
                return []; // Skip categories that don't match the filter
            }

            return $category->subcategories->map(function($sub) use ($category) {
                return [
                    'name' => $sub->name,
                    'img' => $sub->image,
                    'category_id' => $category->id,
                    'subcategory_id' => $sub->id,
                    'subcategory_slug' => $sub->slug,
                    'product_count' => $sub->products_count
                ];
            });
        })->toArray();

        return view('pages.categories', compact('categories', 'allCategories', 'categoryMappings', 'filter'));
    }
}
