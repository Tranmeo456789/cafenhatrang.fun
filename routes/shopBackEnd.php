<?php

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

//shop tdoctor

use App\Http\Controllers\BackEnd\CatPostController;
use App\Http\Controllers\BackEnd\CatProductController;
use App\Http\Controllers\BackEnd\ColorController;
use App\Http\Controllers\BackEnd\DashboardController;
use App\Http\Controllers\BackEnd\FeeShipController;
use App\Http\Controllers\BackEnd\ImportCouponController;
use App\Http\Controllers\BackEnd\OrderController;
use App\Http\Controllers\BackEnd\PageController;
use App\Http\Controllers\BackEnd\PostController;
use App\Http\Controllers\BackEnd\ProductController;
use App\Http\Controllers\BackEnd\SettingController;
use App\Http\Controllers\BackEnd\SliderController;
use App\Http\Controllers\BackEnd\UnitController;
use App\Http\Controllers\BackEnd\UserController;
use App\Http\Controllers\BackEnd\WarehouseController;

$prefixShopBackEnd = '/backend';
Route::group(['prefix' => $prefixShopBackEnd, 'namespace' => 'BackEnd', 'middleware' => ['auth']], function () { 
   
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
        Route::get('/loc-doanh-thu-theo-thoi-gian',[DashboardController::class,'filterInDay'])->name('dashboard.filterInDay');

        Route::get('/danh-sach-don-vi-tinh',[UnitController::class,'index'])->name('unit')->middleware('can:list_unit');
        Route::get('/them-don-vi-tinh',[UnitController::class,'form'])->name('unit.add')->middleware('can:add_unit');
        Route::get('/sua-don-vi-tinh/{id}',[UnitController::class,'form'])->name('unit.edit')->middleware('can:edit_unit');
        Route::post('/luu-don-vi-tinh',[UnitController::class,'save'])->name('unit.save');
        Route::get('/xoa-don-vi-tinh/{id}',[UnitController::class,'delete'])->name('unit.delete')->middleware('can:delete_unit');

        Route::get('/danh-sach-mau',[ColorController::class,'index'])->name('color')->middleware('can:list_color');
        Route::get('/them-mau',[ColorController::class,'form'])->name('color.add')->middleware('can:add_color');
        Route::get('/sua-mau/{id}',[ColorController::class,'form'])->name('color.edit')->middleware('can:edit_color');
        Route::post('/luu-mau',[ColorController::class,'save'])->name('color.save');
        Route::get('/xoa-mau/{id}',[ColorController::class,'delete'])->name('color.delete')->middleware('can:delete_color');

        Route::get('/danh-sach-danh-muc-san-pham',[CatProductController::class,'index'])->name('catProduct')->middleware('can:list_cat_product');
        Route::get('/them-danh-muc-san-pham',[CatProductController::class,'form'])->name('catProduct.add')->middleware('can:add_cat_product');
        Route::get('/sua-danh-muc-san-pham/{id}',[CatProductController::class,'form'])->name('catProduct.edit')->middleware('can:edit_cat_product');
        Route::post('/luu-danh-muc-san-pham',[CatProductController::class,'save'])->name('catProduct.save');
        Route::get('/xoa-danh-muc-san-pham/{id}',[CatProductController::class,'delete'])->name('catProduct.delete')->middleware('can:delete_cat_product');
        Route::get('move-{type}/{id}',[CatProductController::class,'move'])->name('catProduct.move');

        Route::get('/danh-sach-san-pham',[ProductController::class,'index'])->name('product')->middleware('can:list_product');
        Route::get('/them-san-pham',[ProductController::class,'form'])->name('product.add')->middleware('can:add_product');
        Route::get('/sua-san-pham/{id}',[ProductController::class,'form'])->name('backend.product.edit')->middleware('can:edit_product');
        Route::post('/luu-san-pham',[ProductController::class,'save'])->name('product.save');
        Route::get('/xoa-san-pham/{id}',[ProductController::class,'delete'])->name('backend.product.delete')->middleware('can:delete_product');
        Route::get('/chi-tiet-san-pham/{id}',[ProductController::class,'getItem'])->name('product.getItem');
   
        Route::get('/danh-sach-don-hang',[OrderController::class,'index'])->name('order')->middleware('can:list_order');
        Route::get('/chi-tiet-don-hang/{id}',[OrderController::class,'detail'])->name('backend.order.detail')->middleware('can:detail_order');
        Route::post('/cap-nhat-trang-thai-don-hang',[OrderController::class,'changeStatusOrder'])->name('order.changeStatusOrder');
        Route::post('/luu-don-hang',[OrderController::class,'save'])->name('order.save');

        Route::get('/danh-sach-trang',[PageController::class,'index'])->name('page')->middleware('can:list_page');
        Route::get('/them-trang',[PageController::class,'form'])->name('page.add')->middleware('can:add_page');
        Route::get('/sua-trang/{id}',[PageController::class,'form'])->name('backend.page.edit')->middleware('can:edit_page');
        Route::post('/luu-trang',[PageController::class,'save'])->name('page.save');
        Route::get('/xoa-trang/{id}',[PageController::class,'delete'])->name('backend.page.delete')->middleware('can:delete_page');

        Route::get('/danh-sach-danh-muc-bai-viet',[CatPostController::class,'index'])->name('catPost')->middleware('can:list_cat_post');
        Route::get('/them-danh-muc-bai-viet',[CatPostController::class,'form'])->name('catPost.add')->middleware('can:add_cat_post');
        Route::get('/sua-danh-muc-bai-viet/{id}',[CatPostController::class,'form'])->name('catPost.edit')->middleware('can:edit_cat_post');
        Route::post('/luu-danh-muc-bai-viet',[CatPostController::class,'save'])->name('catPost.save');
        Route::get('/xoa-danh-muc-bai-viet/{id}',[CatPostController::class,'delete'])->name('catPost.delete')->middleware('can:delete_cat_post');

        Route::get('/danh-sach-bai-viet',[PostController::class,'index'])->name('post')->middleware('can:list_post');
        Route::get('/them-bai-viet',[PostController::class,'form'])->name('post.add')->middleware('can:add_post');
        Route::get('/sua-bai-viet/{id}',[PostController::class,'form'])->name('backend.post.edit')->middleware('can:edit_post');
        Route::post('/luu-bai-viet',[PostController::class,'save'])->name('post.save');
        Route::get('/xoa-bai-viet/{id}',[PostController::class,'delete'])->name('backend.post.delete')->middleware('can:delete_post');

        Route::get('/danh-sach-nguoi-dung',[UserController::class,'index'])->name('user')->middleware('can:list_user');
        Route::get('/them-nguoi-dung',[UserController::class,'form'])->name('user.add')->middleware('can:add_user');
        Route::get('/sua-nguoi-dung/{id}',[UserController::class,'form'])->name('backend.user.edit')->middleware('can:edit_user');
        Route::post('/luu-nguoi-dung',[UserController::class,'save'])->name('user.save');
        Route::get('/xoa-nguoi-dung/{id}',[UserController::class,'delete'])->name('backend.user.delete')->middleware('can:delete_user');

        Route::get('/danh-sach-slider',[SliderController::class,'index'])->name('slider')->middleware('can:list_slider');
        Route::get('/them-slider',[SliderController::class,'form'])->name('slider.add')->middleware('can:add_slider');
        Route::get('/sua-slider/{id}',[SliderController::class,'form'])->name('backend.slider.edit')->middleware('can:edit_slider');
        Route::post('/luu-slider',[SliderController::class,'save'])->name('slider.save');
        Route::get('/up-vi-tri-slider/{id}',[SliderController::class,'up'])->name('backend.slider.up')->middleware('can:change_localtion');
        Route::get('/xoa-slider/{id}',[SliderController::class,'delete'])->name('backend.slider.delete')->middleware('can:delete_slider');
        
        Route::get('/theme-trang-chu',[SettingController::class,'formInfomation'])->name('setting.infomation');
        Route::post('/luu-theme-trang-chu',[SettingController::class,'saveInfomation'])->name('setting.infomation.save');

        Route::get('/danh-sach-phi-ship',[FeeShipController::class,'index'])->name('feeShip')->middleware('can:list_unit');
        Route::get('/them-phi-ship',[FeeShipController::class,'form'])->name('feeShip.add')->middleware('can:add_unit');
        Route::get('/sua-phi-ship/{id}',[FeeShipController::class,'form'])->name('feeShip.edit')->middleware('can:edit_unit');
        Route::post('/luu-phi-ship',[FeeShipController::class,'save'])->name('feeShip.save');
        Route::get('/xoa-phi-ship/{id}',[FeeShipController::class,'delete'])->name('feeShip.delete')->middleware('can:delete_unit');

        Route::get('/danh-sach-kho-hang',[WarehouseController::class,'index'])->name('warehouse')->middleware('can:list_unit');
        Route::get('/them-kho-hang',[WarehouseController::class,'form'])->name('warehouse.add')->middleware('can:add_unit');
        Route::get('/sua-kho-hang/{id}',[WarehouseController::class,'form'])->name('warehouse.edit')->middleware('can:edit_unit');
        Route::post('/luu-kho-hang',[WarehouseController::class,'save'])->name('warehouse.save');
        Route::get('/xoa-kho-hang/{id}',[WarehouseController::class,'delete'])->name('warehouse.delete')->middleware('can:delete_unit');
        Route::get('/thong-tin-kho-hang',[WarehouseController::class,'info'])->name('warehouse.info');

        Route::get('/danh-sach-phieu-nhap-hang',[ImportCouponController::class,'index'])->name('importCoupon');
        Route::get('/them-phieu-nhap-hang',[ImportCouponController::class,'form'])->name('importCoupon.add');
        Route::get('/sua-phieu-nhap-hang/{id}',[ImportCouponController::class,'form'])->name('importCoupon.edit');
        Route::post('/luu-phieu-nhap-hang',[ImportCouponController::class,'save'])->name('importCoupon.save');
        Route::get('/xoa-phieu-nhap-hang/{id}',[ImportCouponController::class,'delete'])->name('importCoupon.delete');
});
