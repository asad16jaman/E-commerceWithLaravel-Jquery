<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CatagoryController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCatagoryController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\SubcatagoryContorller;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ForntController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get("/",function(){

//     return "";
// });

Route::get("/",[ForntController::class,"index"])->name("front.index");
Route::get("/shop/{catagory?}/{subCatagory?}",[ShopController::class,"index"])->name("front.shop");
Route::get("/product/{slug}",[ShopController::class,"product"])->name("front.product");
Route::get("/cart",[CardController::class,"cart"])->name("front.cart");
Route::post("/add-to-cart",[CardController::class,"addToCart"])->name("front.addToCart");
Route::post("/update-cart",[CardController::class,"updateCart"])->name("front.updateCart");
Route::delete("/delete-item",[CardController::class,"deleteItem"])->name("front.deleteItem.cart");
Route::get("/checkout",[CardController::class,"checkout"])->name("front.checkout");
Route::post("/process-checkout",[CardController::class,"processCheckout"])->name("front.processCheckout");
Route::get("/thanks/{orderId}",[CardController::class,"thankyou"])->name("front.thankyou");
Route::post("/get-order-summery",[CardController::class,"getOrderSummery"])->name("front.getOrderSummery");
Route::post("/apply-discount",[CardController::class,"applyDiscount"])->name("front.applyDiscount");
Route::post("/remove-discount",[CardController::class,"removeCoupon"])->name("front.removeCoupon");





Route::group(["prefix" => "account"],function(){
 
    Route::group(["middleware" => "guest"],function(){
        
        Route::get("/login",[AuthController::class,"login"])->name("account.login");
        Route::get("/register",[AuthController::class,"register"])->name("account.register");
        Route::post("/process-register",[AuthController::class,"processRegister"])->name("account.processRegister");
        Route::post("/login",[AuthController::class,"authenticate"])->name("account.authenticate");
    });


    Route::group(["middleware" => "auth"],function(){




        Route::get("/profile",[AuthController::class,"profile"])->name('account.profile');
        Route::get("/my-orders",[AuthController::class,"orders"])->name('account.orders');
        Route::get("/order-detail/{id}",[AuthController::class,"orderDetail"])->name('account.orderDetail')->whereNumber('id');










        Route::get("/logout",[AuthController::class,"logout"])->name('account.logout');
    });



});




Route::group(["prefix"=>"admin"],function(){

    Route::group(["middleware"=>"admin.guest"],function(){
        Route::get("login",[AdminLoginController::class,"index"])->name("admin.login");
        Route::post("/authenicate",[AdminLoginController::class,"authenicate"])->name("admin.authenicate");
    });

    
    Route::group(["middleware"=>"admin.auth"],function(){

        Route::get("dashbord",[HomeController::class,"index"])->name("admin.dashboard");
        Route::get("/logout",[HomeController::class,"logout"])->name("admin.logout");
        
        // all route for catagory
        Route::get("/catagories",[CatagoryController::class,"index"])->name("catagories.index");
        Route::get("/catagories/create",[CatagoryController::class,"create"])->name("catatories.create");
        Route::post("catagories/create",[CatagoryController::class,"store"])->name("catatories.store");
        Route::get("/catagories/{id?}/edit",[CatagoryController::class,"edit"])->name("catagories.edit")->whereNumber("id");
        Route::put("/catagories/{id?}/update",[CatagoryController::class,"update"])->name("catagories.update")->whereNumber("id");
        Route::delete("/catagories/{id?}/delete",[CatagoryController::class,"destroy"])->name("catagories.delete")->whereNumber("id");

        //sub catagory Route
        Route::get("/subcatagories",[SubcatagoryContorller::class,"index"])->name("subcatagory.index");
        Route::get("/subcatagory/create",[SubcatagoryContorller::class,"create"])->name("subcatagory.create");
        Route::post("/subcatagory/store",[SubcatagoryContorller::class,"store"])->name("subcatagory.store");
        Route::get("/subcatagory/{id?}/edit",[SubcatagoryContorller::class,"edit"])->name("subcatagory.edit");
        Route::put("/subcatagory/{id?}/update",[SubcatagoryContorller::class,"update"])->name("subcatagory.update");
        Route::delete("/subcatagory/{id?}/delete",[SubcatagoryContorller::class,"destroy"])->name("subcatagory.delete");

        //brand route

        Route::get("/brands",[BrandController::class,"index"])->name("brand.index");
        Route::get("/brand/create",[BrandController::class,"create"])->name("brand.create");
        Route::post("/brand/store",[BrandController::class,"store"])->name("brand.store");
        Route::get("/brand/{id?}/edit",[BrandController::class,"edit"])->name("brand.edit");
        Route::put("/brand/{id?}/update",[BrandController::class,"update"])->name("brand.update");
        Route::delete("/brand/{id?}/delete",[BrandController::class,"destroy"])->name("brand.delete");

        //Product Routes
        Route::get("/products",[ProductController::class,"index"])->name("product.index");
        Route::get("/product/create",[ProductController::class,"create"])->name("product.create");
        Route::post("/product/store",[ProductController::class,"store"])->name("product.store");
        Route::get("/product/{product}/edit",[ProductController::class,"edit"])->name("product.edit")->whereNumber("product");
        Route::put("/product/{product_id}/update",[ProductController::class,"update"])->name("product.update")->whereNumber("product_id");
        Route::get("/related-product",[ProductController::class,"relatedProduct"])->name("product.relatedProduct");


        //updatd image route
        Route::post("product/image/{id?}/update",[ProductImageController::class,"update"])->name("product.image.update")->whereNumber("id");
        Route::delete("product/image/delete",[ProductImageController::class,"destroy"])->name("product.image.delete")->whereNumber("id");



        //getting subCatagory in product CreatePage Select input
        Route::get("getSubcatagory",[ProductSubCatagoryController::class,"index"])->name("getSubcatagory.index");
        //creating image as temperory folder
        Route::post("temp-images",[TempImagesController::class,"create"])->name("temp-images.create");

        //shigging route
        Route::get('/shipping/create',[ShippingController::class,"create"])->name('shipping');
        Route::post('/shipping',[ShippingController::class,"store"])->name('shipping.store');
        Route::get('/shipping/{id}',[ShippingController::class,"edit"])->name('shipping.edit');
        Route::put('/shipping/{id}',[ShippingController::class,"update"])->name('shipping.update');
        Route::delete('/shipping/delete/{id}',[ShippingController::class,"destroy"])->name('shipping.delete');


        //coupon code route
        Route::get("/coupon",[DiscountCodeController::class,"index"])->name("coupon.index");
        Route::get("/coupon/create",[DiscountCodeController::class,"create"])->name("coupon.create");
        Route::post("/copun/store",[DiscountCodeController::class,"store"])->name("coupon.store");
        Route::get("/coupon/{id}/edit",[DiscountCodeController::class,"edit"])->name("coupon.edit")->whereNumber("id");
        Route::put("/coupon/{id}/update",[DiscountCodeController::class,"update"])->name("coupon.update")->whereNumber("id");
        Route::delete("/coupon/{id}",[DiscountCodeController::class,"destroy"])->name("coupon.delete");

        //orders route
        Route::get('/orders',[OrderController::class,"index"])->name('orders.index');
        Route::get('/orders/{id}',[OrderController::class,"detail"])->name('orders.detail');
        Route::post('/order/update-status/{id}',[OrderController::class,"changeOrderStatus"])->name('orders.changeOrderStatus');
        Route::post('/order/send-email/{orderId}',[OrderController::class,"sendEmailCustom"])->name('orders.sendEmailCustom');
        

       

        
        
        



    });
    
    
    
    

});




// Route::get('/test',function(){
   
// });

