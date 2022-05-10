<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::with('productGalleries')->latest()->get();
        // dd($products);
        return view('pages.index', compact('products'));
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function details(Product $product)
    {
        $product->load('productGalleries');
        $recommendations = Product::with('productGalleries')->inRandomOrder()->take(4)->get();
        return view('pages.details', compact('product', 'recommendations'));
    }

    public function success()
    {
        return view('pages.success');
    }
}
