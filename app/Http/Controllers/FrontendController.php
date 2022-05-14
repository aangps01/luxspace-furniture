<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

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

    public function checkout(TransactionRequest $request)
    {
        $validated = $request->validated();

        // get cart
        $carts = Cart::with(['product'])->where('user_id', auth()->user()->id)->get();

        // create transaction
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'total_price' => $carts->sum('product.price'),
        ]);

        // create transaction item
        foreach ($carts as $cart) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product->id,
            ]);

            $items[] = array(
                'id' => 'ITEM-' . $cart->product->id,
                'name' => $cart->product->name,
                'price' => (int)$cart->product->price,
                'quantity' => 1,
            );
        }

        // delete cart
        Cart::where('user_id', auth()->user()->id)->delete();

        // inializating midtrans config
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // midtrans data
        $params = array(
            'transaction_details' => array(
                'order_id' => 'LUX-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price,
            ),
            'item_details' => $items,
            'customer_details' => array(
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
                'address' => $transaction->address,
            ),
        );

        // do midtrans payment
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($params)->redirect_url;

            // save payment url to transaction
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
