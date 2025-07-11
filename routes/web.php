<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ListordersController;
use App\Http\Controllers\ListusersController;
use App\Http\Controllers\ProductAtrrController;
use App\Http\Controllers\ProductsController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* FrontEnd Location */
Route::get('/', [IndexController::class, 'index']);
Route::get('/list-products', [IndexController::class, 'shop']);
Route::get('/cat/{id}', [IndexController::class, 'listByCat'])->name('cats');
Route::get('/product-detail/{id}', [IndexController::class, 'detialpro']);
Route::get('/About-Us', [AboutUsController::class, 'index'])->name('about.us');
///////////contactus//////
Route::get('/contact', [ContactUsController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactUsController::class, 'storeMessage'])->name('contact.store');
////// get Attribute ////////////
Route::get('/get-product-attr', [IndexController::class, 'getAttrs']);
///// Cart Area /////////
Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/viewcart', [CartController::class, 'index']);
Route::get('/cart/deleteItem/{id}', [CartController::class, 'deleteItem'])->name('cart.deleteItem');
Route::get('/cart/update-quantity/{id}/{quantity}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
/////////////////////////
/// Apply Coupon Code
Route::post('/apply-coupon', [CouponController::class, 'applycoupon']);
/// Simple User Login /////
Route::get('/login_page', [UsersController::class, 'index']);
Route::post('/register_user', [UsersController::class, 'register']);
Route::post('/user_login', [UsersController::class, 'login']);
Route::get('/logout', [UsersController::class, 'logout']);

////// API Raja Ongkir ///////////
Route::get('delivery/getprovince', [DeliveryController::class, 'getprovince']);
Route::get('delivery/getcity', [DeliveryController::class, 'getcity']);
Route::get('delivery/checkshipping', [DeliveryController::class, 'checkshipping']);
Route::post('delivery/processShipping', [DeliveryController::class, 'processShipping']);

////// User Authentications //////////
Route::group(['Middleware' => 'FrontLogin_middleware'], function () {
    Route::get('/myaccount', [UsersController::class, 'account']);
    Route::put('/update-profile/{id}', [UsersController::class, 'updateprofile']);
    Route::put('/update-password/{id}', [UsersController::class, 'updatepassword']);
    Route::get('/check-out', [CheckOutController::class, 'index']);
    Route::post('/submit-checkout', [CheckOutController::class, 'submitcheckout']);
    Route::get('/order-review', [OrdersController::class, 'index']);
    Route::post('/submit-order', [OrdersController::class, 'order']);
    Route::get('/cod', [OrdersController::class, 'cod']);
    Route::get('/banktransfer', [OrdersController::class, 'banktransfer']);
});



Auth::routes(['register' => false]);

// Admin Authentication Routes
Route::get('admin/login', [AdminAuthController::class, 'adminLoginForm'])->name('admin.login'); // Route to show login form
Route::post('admin/login', [AdminAuthController::class, 'adminLogin'])->name('admin.login.submit'); // Route for processing login form
Route::post('admin/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout'); // Route for logging out

// Redirect from /admin to /admin/dashboard if authenticated
Route::middleware('auth:admin')->get('/admin', function () {
    return redirect()->route('admin_home');
});

// Protected Admin Routes
Route::middleware('auth:admin')->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin_home');

    // Settings Area
    Route::get('/settings', [AdminController::class, 'settings']);
    Route::get('/check-pwd', [AdminController::class, 'chkPassword']);
    Route::post('/update-pwd', [AdminController::class, 'updatAdminPwd']);

    // Contact Messages
    Route::get('/contact-messages', [ContactUsController::class, 'showMessages'])->name('admin.contact.messages');

    // Category Management
    Route::resource('/category', CategoryController::class);
    Route::get('delete-category/{id}', [CategoryController::class, 'destroy']);
    Route::get('/check_category_name', [CategoryController::class, 'checkCateName']);

    // Product Management
    Route::resource('/product', ProductsController::class);
    Route::get('delete-product/{id}', [ProductsController::class, 'destroy']);
    Route::get('delete-image/{id}', [ProductsController::class, 'deleteImage']);

    // Product Attributes
    Route::resource('/product_attr', ProductAtrrController::class);
    Route::get('delete-attribute/{id}', [ProductAtrrController::class, 'deleteAttr']);

    // Product Image Gallery
    Route::resource('/image-gallery', ImagesController::class);
    Route::get('delete-imageGallery/{id}', [ImagesController::class, 'destroy']);

    // Coupons Area
    Route::resource('/coupon', CouponController::class);
    Route::get('delete-coupon/{id}', [CouponController::class, 'destroy']);

    // Orders Area
    Route::resource('/order', ListordersController::class);
    Route::get('/status/update', [ListordersController::class, 'changestatus'])->name('users.update.status');
    Route::get('changestatus', [ListordersController::class, 'changestatus']);
    Route::get('delete-order/{id}', [ListordersController::class, 'destroy']);
    Route::get('/orders/{id}', [ListordersController::class, 'show'])->name('order.show');

    // Users Area
    Route::resource('/user', ListusersController::class);
    Route::get('delete-user/{id}', [ListusersController::class, 'destroy']);
});
