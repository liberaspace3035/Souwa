<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)->limit(8)->get();
        $newProducts = Product::where('is_new', true)->limit(8)->get();
        $limitedProducts = Product::where('is_limited', true)->limit(8)->get();
        $bestsellingProducts = Product::orderBy('id', 'desc')->limit(8)->get();
        
        // 最新の公開済みNEWSを1件取得
        $latestNews = News::where('is_published', true)
            ->where(function($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest()
            ->first();

        return view('home', compact('featuredProducts', 'newProducts', 'limitedProducts', 'bestsellingProducts', 'latestNews'));
    }
}
