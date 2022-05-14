<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/details/{product}', [FrontendController::class, 'details'])->name('details');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard.index');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    Route::post('/cart/{product}', [FrontendController::class, 'addCart'])->name('cart.add');
    Route::delete('/cart/{product}', [FrontendController::class, 'removeCart'])->name('cart.remove');
    Route::post('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
    Route::get('/success', [FrontendController::class, 'success'])->name('success');
});


Route::middleware(['auth:sanctum', 'verified'])->name('dashboard.')->prefix('dashboard')->group(function () {

    Route::middleware(['admin'])->group(function () {
        // admin routes
        Route::resource('product', ProductController::class)->except(['show']);
        Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
            'index',
            'create',
            'store',
            'destroy'
        ]);
        Route::resource('transaction', TransactionController::class);
        Route::resource('user', UserController::class);
    });
});
