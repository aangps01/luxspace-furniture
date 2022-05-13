<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
        $carts = Cart::with('product.productGalleries')->where('user_id', auth()->user()->id)->get();
        return view('pages.cart', compact('carts'));
    }

    public function addCart(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        if (!$cart) {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => auth()->user()->id,
            ]);
        }
        return redirect()->route('cart');
    }

    public function removeCart(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        if ($cart) {
            $cart->delete();
        }
        return redirect()->route('cart');
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
