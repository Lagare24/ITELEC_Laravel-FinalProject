<!-- 


        // Route::get('/', [HomeController::class, 'index']);

        // Route::get('/index', function () {
        //     return view('index');
        // })->middleware(['auth', 'verified'])->name('index');


        // Route::get('/product', [ProductController::class], 'index')->name('product.index');

        // Route::get('/login', function () {
        //     return view('');
        // });

        // Route::get('/', function () {
        //     return view('test');
        // });
        // Route::get('/products', function () {
        //     return view('test');
        // }); -->

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index', [HomeController::class, 'index'])->name('index'); // Add this line


Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/order/summary/{id}', [OrderController::class, 'summary'])->name('order.summary');

});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

require __DIR__.'/auth.php';


// use App\Models\Product;
// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\OrderController;

// Route::get('/', [HomeController::class, 'index']);

// Route::get('/test', function () {
//     return view('test');
// });


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::resource('products', ProductController::class);
// });


// Route::middleware(['auth'])->group(function () {
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//     Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
//     Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
// });


// require __DIR__ . '/auth.php';
