<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        $popularProducts = ProductVariant::whereHas('product')
            ->with(['product', 'category'])
            ->latest()
            ->limit(4)
            ->get();
        


        $homeCategories = Category::where('position', 'home')->get();
        $homeProducts = ProductVariant::whereHas('category', function($q) {
            $q->where('position', 'home');
        })->with(['product', 'category'])->orderBy('created_at')->limit(5)->get();

        return view('pages.home', compact('banners', 'popularProducts', 'homeCategories', 'homeProducts'));
    }
}
