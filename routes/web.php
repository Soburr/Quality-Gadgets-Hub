<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PaystackWebhookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FeaturedController;
use App\Http\Controllers\Admin\MailPreviewController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/brand/{brand}', [BrandController::class, 'show'])->name('brand.show');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/great-finds', [FeaturedController::class, 'index'])->name('featured.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{itemKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{itemKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout/buy-now/{product}', [CartController::class, 'buyNow'])->name('checkout.buyNow');

Route::get('/terms-of-service', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/return-policy', [PageController::class, 'returns'])->name('pages.returns');
Route::get('/refund-replacement-guidelines', [PageController::class, 'refundGuidelines'])->name('pages.refundGuidelines');
Route::get('/about-us', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact-us', [PageController::class, 'contact'])->name('pages.contact');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/paystack/webhook', [PaystackWebhookController::class, 'handle'])->name('paystack.webhook');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.show');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/bank-transfer/{order}', [App\Http\Controllers\CheckoutController::class, 'bankTransfer'])->name('checkout.bankTransfer');

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');

    Route::post('/orders/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('order.cancel');

    Route::get('/checkout/pay/{order}/retry', [PaystackController::class, 'retry'])->name('paystack.retry');
    Route::get('/paystack/callback', [PaystackController::class, 'callback'])->name('paystack.callback');
});

    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class)->except('show');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy']);
    Route::resource('brands', AdminBrandController::class)->except('show');

    Route::get('/mail-preview/welcome', [MailPreviewController::class, 'welcome'])->name('mail-preview.welcome');
    Route::get('/mail-preview/order-confirmation', [MailPreviewController::class, 'orderConfirmation'])->name('mail-preview.orderConfirmation');
    Route::get('/mail-preview/order-status', [MailPreviewController::class, 'orderStatusUpdated'])->name('mail-preview.orderStatusUpdated');

    Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::put('/settings/password', [AdminSettingController::class, 'updatePassword'])->name('settings.updatePassword');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/export', [AdminUserController::class, 'export'])->name('users.export');
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
});