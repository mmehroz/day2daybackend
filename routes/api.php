<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SliderController;
use App\Http\Resources\CouponResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\navController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function (Request $request) {
        return auth()->user();
    });

    Route::get('/list/wishlists', [WishlistController::class,'listWishList'])->name('listWishlist');
    Route::get('/add/product/to-wishlist/{product_id}',[WishlistController::class,'addToWishlist'])->name('addtoWishlist');
    Route::get('/remove/from-wishlist/{wish_id}', [WishlistController::class,'removefromWishList'])->name('removefromWishList');
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::any('/demowebnav', [navController::class, 'demowebnav']);
Route::any('/webnav', [navController::class, 'webnav']);
Route::any('/parentnav', [navController::class, 'parentnav']);
Route::any('/subnav', [navController::class, 'subnav']);
Route::any('/innersubnav', [navController::class, 'innersubnav']);
Route::any('/categories', [navController::class, 'categories']);
Route::any('/featuredproducts', [navController::class, 'featuredproducts']);
Route::any('/flashsale', [navController::class, 'flashsale']);
Route::any('/newarrival', [navController::class, 'newarrival']);
Route::any('/topbrands', [navController::class, 'topbrands']);
Route::any('/productdetails', [navController::class, 'productdetails']);
Route::any('/createorder', [navController::class, 'createorder']);
Route::any('/orderlist', [navController::class, 'orderlist']);
Route::any('/orderdetails', [navController::class, 'orderdetails']);
Route::any('/contactus', [navController::class, 'contactus']);
Route::any('/review', [navController::class, 'review']);
Route::any('forgetpassword', [navController::class,'forgetpassword']);
Route::any('verifycode', [navController::class,'verifycode']);
Route::any('resetpassword', [navController::class,'resetpassword']);
Route::any('/changepassword', [navController::class, 'changepassword'])->name('api.changepassword');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/slider/{type}', [SliderController::class,'getSliders']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('api.product.show');
Route::get('/coupon/{code}', [CouponController::class, 'couponCheck'])->name('api.coupon.code');
Route::get('/product/{product_id}', [ProductController::class, 'getAll'])->name('api.product.all');
Route::any('/productsub/{product_id}', [ProductController::class, 'getsub'])->name('api.product.sub');
Route::get('/productinner/{product_id}', [ProductController::class, 'getinner'])->name('api.product.inner');
Route::get('/brandproduct/{brand_id}', [ProductController::class, 'brandproduct'])->name('api.brandproduct');
Route::get('/getsale/{type}', [ProductController::class, 'getsale'])->name('api.getsale');
Route::get('/searchproduct/{searchname}', [ProductController::class, 'searchproduct'])->name('api.searchproduct');
Route::get('/tagproduct/{tagname}', [ProductController::class, 'tagproduct'])->name('api.tagproduct');
Route::any('/subscription', [navController::class, 'subscription'])->name('api.subscription');
Route::any('/addproduct', [ProductController::class, 'addproduct'])->name('api.addproduct');
Route::any('/getmultifilter', [ProductController::class, 'getmultifilter'])->name('api.getmultifilter');
Route::any('/getmultibrand', [ProductController::class, 'getmultibrand'])->name('api.getmultibrand');
Route::any('/webvisitors', [navController::class, 'webvisitors'])->name('api.webvisitors');