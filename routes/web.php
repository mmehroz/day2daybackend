<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\navadminController;

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

    Route::group(['middleware' => ['guest']], function() {
        Route::get('/login', [LoginController::class, 'show'])->name('login.show');
        Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
    });

    Route::group(['middleware' => ['permission', 'auth:sanctum']], function() {

        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/profile', [UsersController::class, 'profile'])->name('profile.view');
        Route::get('/password/edit', [UsersController::class, 'password_edit'])->name('password.edit');
        Route::get('/productsall', [ProductController::class, 'getAll'])->name('products.all');
        Route::get('/admin/category/subcategory/ajax/{category_id}', [SubSubCategoryController::class, 'getSubCategory']);
        Route::get('/admin/category/subsubcategory/ajax/{subcategory_id}', [SubSubCategoryController::class, 'getSubSubCategory']);
        Route::get('/changesliderstatus', [SliderController::class, 'changeSliderStatus'])->name('change-product-status');


        Route::post('/password/update', [UsersController::class, 'password_update'])->name('password.update');
        Route::post('/products/image/update', [ProductController::class, 'MultiImageUpdate'])->name('update-product-image');


        Route::get('/orders/status/update/{order_id}/{status}', [OrderController::class, 'orderStatusUpdate'])->name('order-status.update');
        Route::get('/invoice-download/{order_id}', [OrderController::class, 'adminInvoiceDownload'])->name('admin-invoice-download');

        Route::resource('users', UsersController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('sub_category', SubCategoryController::class);
        Route::resource('sub_sub_category', SubSubCategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('orders', OrderController::class);

        Route::any('/parentnavlist', [navadminController::class, 'parentnavlist']);
    });
        Route::any('/productlookup', [ProductController::class, 'productlookup'])->name('products.lookup');
        Route::any('/submitlookup', [ProductController::class, 'submitlookup'])->name('products.submitlookup');

