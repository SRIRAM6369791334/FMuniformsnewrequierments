<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($slug = null)
    {
        $activeFilter = null;
        if ($slug) {
            $category = \App\Models\Category::where('slug', $slug)->first();
            if ($category) {
                // Find the filter_class associated with this category
                $firstBlog = Blog::where('category_id', $category->id)->first();
                if ($firstBlog) {
                    $activeFilter = $firstBlog->filter_class;
                }
            }
        }

        // Let JavaScript handle all filtering - no URL parameters needed for data fetch
        $blogs = Blog::with('category')->latest()->get();

        // Always get all categories for filter buttons
        $allCategories = Blog::with('category')
            ->get()
            ->groupBy('category.name')
            ->filter(fn($blogs) => $blogs->first()->category !== null) // Ensure category exists
            ->map(function($blogs, $categoryName) {
                return [
                    'name' => $categoryName,
                    'slug' => $blogs->first()->category->slug,
                    'filter_class' => $blogs->first()->filter_class,
                    'count' => $blogs->count()
                ];
            });

        return view('pages.blog', compact('blogs', 'allCategories', 'activeFilter'));
    }

    public function show($slug)
    {
        $blog = Blog::with('category')->where('slug', $slug)->firstOrFail();
        return view('pages.blog-single', compact('blog'));
    }
}
