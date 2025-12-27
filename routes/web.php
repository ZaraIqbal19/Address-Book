<?php
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

// Route::get('/', [AdminController::class, 'showlatestproducts'])->name('home');

// Product Browsing
Route::get('/products', [AdminController::class, 'index'])->name('products');
Route::get('/product/{id}', [AdminController::class, 'show'])->name('product.show');

// Search
Route::get('/search', [AdminController::class, 'search'])->name('product.search');

// Cart
Route::post('/cart/add/{id}', [UserController::class, 'add'])->name('cart.add');
Route::get('/cart', [UserController::class, 'index'])->name('cart');
Route::post('/cart/update/{id}', [UserController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [UserController::class, 'remove'])->name('cart.remove');

// Checkout & Orders
Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
Route::post('/order/place', [UserController::class, 'store'])->name('order.place');
Route::get('/order/success', [UserController::class, 'success'])->name('order.success');

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

    Route::get('/admindashboard', [AdminController::class, 'admindashboard'])->name('admin.admindashboard');

    // Category Management
    // Route::resource('/categories', AdminController::class,'ShowCatogries');

    // Product Management
    Route::resource('/products', AdminController::class);

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



Route::get('/home', function () {
    return view('User.index');
});


Route::get('/uploadcategory',function(){
    return view('admin.productcategory');
    });
    Route::get('/uploadproduct',[AdminController::class,('fetchcategory')]);
    Route::post('/addcategory',[AdminController::class,('addcategory')]);
    Route::post('/insertproduct',[AdminController::class,('uploadproduct')]);
    Route::get('/fetchproduct',[AdminController::class,('fetchproducts')]);
    Route::post('/addtocart',[AdminController::class,('addtocart')]);


6


Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

});

