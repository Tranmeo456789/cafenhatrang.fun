<?php

use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\BackEnd\DistrictController;
use App\Http\Controllers\BackEnd\WardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

Route::get('/',[HomeController::class, 'index'])->name('home');
//Auth::routes(['register' => true]);

Route::get('/login',[AuthLoginController::class,'showLoginForm'])->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::get('saveAjax/cart',[CartController::class,'saveAjax'])->name('cart.saveAjax');
Route::get('show/cart',[CartController::class,'show'])->name('cart.show');
Route::post('add/cart',[CartController::class,'add'])->name('cart.add');
Route::get('remove/cart/{id}',[CartController::class,'remove'])->name('cart.remove');
Route::get('cart/destroy',[CartController::class,'destroy'])->name('cart.destroy');
Route::post('cart/udate',[CartController::class,'update'])->name('cart.update');
Route::post('cart/updateCartAjax',[CartController::class,'updateCartAjax'])->name('updateCartAjax');

Route::get('tinh-phi-van-chuyen-ajax',[CartController::class,'feeAjax'])->name('cart.feeAjax');

Route::get('mua-ngay-san-pham/{id}',[OrderController::class,'buynow'])->name('order.buynow');
Route::get('tra-cuu-thong-tin-don-hang',[OrderController::class,'viewSearchPhoneOrder'])->name('order.view_search_phone_order');
Route::get('thanh-toan',[OrderController::class,'checkout'])->name('order.checkout');
Route::post('kiem-tra-thong-tin-so-dien-thoai',[OrderController::class,'searchPhoneOrder'])->name('order.search.phone_order');
Route::get('loc-don-hang-ajax/theo-trang-thai',[OrderController::class,'ajaxFliter'])->name('order.ajaxFliter');
Route::get('xem-don-hang-chi-tiet-ajax/theo-so-dien-thoai',[OrderController::class,'detail'])->name('order.detail');
Route::post('OrderSuccess',[OrderController::class,'OrderSuccess'])->name('OrderSuccess');
Route::get('dat-hang-thanh-cong/{id}',[OrderController::class,'viewOrderSuccess'])->name('order.success');

Route::get('san-pham-{slug}',[ProductController::class,'list_product'])->name('cat0.product');
Route::get('chi-tiet-san-pham/{slug}',[ProductController::class, 'detail'])->name('frontend.product.detail');
Route::get('searchProduct',[ProductController::class,'searchProductAjax'])->name('searchProductAjax');
Route::get('san-pham/{slug1}.html',[ProductController::class,'list_product1'])->name('cat1.product');
Route::get('san-pham',[ProductController::class,'all_product']);
Route::get('tim-kiem',[ProductController::class,'list_search'])->name('frontend.product.search');

Route::get('tin-tuc',[PostController::class,'list'])->name('posts');
Route::get('tin-tuc/{slug}.html',[PostController::class,'detail'])->name('post.detail');


Route::get('{slugpage}.html',[HomeController::class,'pages'])->name('pages');
Route::get('district/get-list',[DistrictController::class,'getListByParentID'])->name('district.getListByParentID');
Route::get('ward/get-list',[WardController::class,'getListByParentID'])->name('ward.getListByParentID');
include_once 'routes/shopBackEnd.php';













