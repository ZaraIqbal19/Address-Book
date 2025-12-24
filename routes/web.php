<?php
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    CategoryController,
    CartController,
    OrderController,
    AdminController
};

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Browsing
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Search
Route::get('/search', [ProductController::class, 'search'])->name('product.search');

// Cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout & Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order/place', [OrderController::class, 'store'])->name('order.place');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// Auth::ROUTES();

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Category Management
    Route::resource('/categories', CategoryController::class);

    // Product Management
    Route::resource('/products', ProductController::class);

    // Database Maintenance
    Route::get('/database', [AdminController::class, 'database'])->name('admin.database');

    Route::get('/backup', [AdminController::class, 'backup'])->name('admin.backup');

    // Reports
    Route::get('/reports/top-products', [AdminController::class, 'topProducts'])->name('admin.reports.products');

    Route::get('/reports/top-customers', [AdminController::class, 'topCustomers'])->name('admin.reports.customers');

    Route::prefix('admin')->middleware(['auth','admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetails'])->name('admin.order.details');
    Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder'])->name('admin.order.delete');

    // Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::delete('/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customer.delete');

});

});

Route::get('/', function () {
    return view('index');
});



Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

});

