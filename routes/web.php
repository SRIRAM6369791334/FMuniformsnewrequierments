<?php

use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

Route::get('/checkout', [App\Http\Controllers\CartController::class, 'showCheckout'])->name('checkout');

Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('process.checkout');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/verify-otp', [App\Http\Controllers\AuthController::class, 'verifyOtp']);

Route::match(['get', 'post'], '/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/category/{slug}', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.category');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::get('/account', [App\Http\Controllers\AccountController::class, 'showAccount'])->middleware('auth')->name('account');
Route::get('/myaccount', function () {
    return view('pages.myaccount');
})->name('myaccount.static');
Route::post('/upload-profile-image', [App\Http\Controllers\AccountController::class, 'uploadProfileImage'])->middleware('auth')->name('upload.profile.image');
Route::post('/account/update-address', [App\Http\Controllers\AccountController::class, 'updateAddress'])->middleware('auth')->name('account.update.address');

// Address management routes
Route::get('/account/address/{addressId}', [App\Http\Controllers\AccountController::class, 'showAddress'])->middleware('auth')->name('account.address.show');
Route::post('/account/address', [App\Http\Controllers\AccountController::class, 'storeAddress'])->middleware('auth')->name('account.address.store');
Route::put('/account/address', [App\Http\Controllers\AccountController::class, 'updateAddress'])->middleware('auth')->name('account.address.update');
Route::delete('/account/address/{addressId}', [App\Http\Controllers\AccountController::class, 'destroyAddress'])->middleware('auth')->name('account.address.destroy');
Route::get('/account/order/{orderId}', [App\Http\Controllers\AccountController::class, 'getOrderDetails'])->middleware('auth')->name('account.order.details');
Route::post('/account/order/{orderId}/cancel', [App\Http\Controllers\AccountController::class, 'cancelOrder'])->middleware('auth')->name('account.order.cancel');
Route::get('/account/bulk-order/{bulkOrderId}', [App\Http\Controllers\AccountController::class, 'getBulkOrderDetails'])->middleware('auth')->name('account.bulk-order.details');

Route::get('/about', [App\Http\Controllers\PageController::class, 'about']);

Route::get('/contact', [App\Http\Controllers\PageController::class, 'contact']);

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store']);

Route::get('/privacy-policy', [App\Http\Controllers\PageController::class, 'privacyPolicy']);

Route::get('/terms-conditions', [App\Http\Controllers\PageController::class, 'termsConditions']);

Route::get('/refund-policy', [App\Http\Controllers\PageController::class, 'refundPolicy']);

Route::get('/customize', [App\Http\Controllers\PageController::class, 'customize']);

Route::post('/bulkorder', [App\Http\Controllers\BulkOrderController::class, 'store'])->middleware('auth');

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoriesController::class, 'index'])->name('categories.slug');

Route::get('/product-detail/{slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('product.detail');

// Review routes
Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

// Wishlist routes
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
Route::delete('/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
Route::post('/wishlist/check', [App\Http\Controllers\WishlistController::class, 'check'])->name('wishlist.check');
Route::post('/wishlist/transfer', [App\Http\Controllers\WishlistController::class, 'transfer'])->name('wishlist.transfer');

// Cart routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::post('/cart/check', [App\Http\Controllers\CartController::class, 'check'])->name('cart.check');
Route::post('/cart/check-multiple', [App\Http\Controllers\CartController::class, 'checkMultiple'])->name('cart.check.multiple');
Route::put('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
Route::delete('/cart', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/transfer', [App\Http\Controllers\CartController::class, 'transfer'])->name('cart.transfer');
Route::post('/cart/cleanup', [App\Http\Controllers\CartController::class, 'cleanup'])->name('cart.cleanup');
Route::post('/check-email-exists', [App\Http\Controllers\CartController::class, 'checkEmailExists'])->name('check.email.exists');
Route::post('/set-checkout-return', [App\Http\Controllers\CartController::class, 'setCheckoutReturn'])->name('set.checkout.return');

// Payment routes
Route::post('/payment/create-order', [App\Http\Controllers\PaymentController::class, 'createOrder'])->name('payment.create');
Route::post('/payment/verify', [App\Http\Controllers\PaymentController::class, 'verifyPayment'])->name('payment.verify');
Route::post('/payment/webhook', [App\Http\Controllers\PaymentController::class, 'handleWebhook'])->name('payment.webhook');
Route::post('/payment/success', [App\Http\Controllers\CartController::class, 'handlePaymentSuccess'])->name('payment.success');

Route::get('/bulkorder', [App\Http\Controllers\PageController::class, 'bulkOrder']);

// Shiprocket routes
Route::prefix('shiprocket')->group(function () {
    // Public routes (no auth required)
    Route::post('/webhook', [App\Http\Controllers\ShiprocketController::class, 'handleWebhook'])->name('shiprocket.webhook');
    Route::post('/check-couriers', [App\Http\Controllers\ShiprocketController::class, 'checkCouriers'])->name('shiprocket.check-couriers');
    Route::get('/track/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'track'])->name('shiprocket.track');
    
    // Protected routes (auth required)
    Route::post('/sync/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'syncOrder'])->middleware('auth')->name('shiprocket.sync');
    Route::post('/cancel/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'cancelOrder'])->middleware('auth')->name('shiprocket.cancel');
    Route::post('/awb/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'generateAWB'])->middleware('auth')->name('shiprocket.awb');
    Route::post('/pickup/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'requestPickup'])->middleware('auth')->name('shiprocket.pickup');
    Route::get('/label/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'generateLabel'])->middleware('auth')->name('shiprocket.label');
    Route::get('/invoice/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'generateInvoice'])->middleware('auth')->name('shiprocket.invoice');
    Route::get('/couriers/{orderId}', [App\Http\Controllers\ShiprocketController::class, 'getAvailableCouriers'])->middleware('auth')->name('shiprocket.couriers');
});
