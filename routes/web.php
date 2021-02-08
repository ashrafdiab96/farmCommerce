<?php

use Illuminate\Support\Facades\Route;

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


/*
|--------------------------------------------------------------------------
| Admin accessed links
|--------------------------------------------------------------------------
*/
Route::middleware('isadmin')->group(function() {

    // Admin controller routes
    Route::get('/admin', 'App\Http\Controllers\AdminController@dashboard');
    Route::get('/orders', 'App\Http\Controllers\AdminController@orders');
    Route::get('/clients', 'App\Http\Controllers\AdminController@clients');
    Route::get('/setadmin/{id}', 'App\Http\Controllers\AdminController@setAdmin');
    Route::get('/removeadmin/{id}', 'App\Http\Controllers\AdminController@removeAdmin');
    Route::get('/deleteclient/{id}', 'App\Http\Controllers\AdminController@deleteClient');

    // Categories controller routes
    Route::get('/categories', 'App\Http\Controllers\CategoryController@categories');
    Route::get('/addcategory', 'App\Http\Controllers\CategoryController@addCategory');
    Route::post('/savecategory', 'App\Http\Controllers\CategoryController@saveCategory');
    Route::get('/editcategory/{id}', 'App\Http\Controllers\CategoryController@editCategory');
    Route::post('/updatecategory/{id}', 'App\Http\Controllers\CategoryController@updateCategory');
    Route::get('/deletecategory/{id}', 'App\Http\Controllers\CategoryController@deleteCategory');

    // Products controller routes
    Route::get('/products', 'App\Http\Controllers\ProductController@products');
    Route::get('/addproduct', 'App\Http\Controllers\ProductController@addProduct');
    Route::post('/saveproduct', 'App\Http\Controllers\ProductController@saveProduct');
    Route::get('/deleteproduct/{id}', 'App\Http\Controllers\ProductController@deleteProduct');
    Route::get('/editproduct/{id}', 'App\Http\Controllers\ProductController@editProduct');
    Route::post('/updateproduct/{id}', 'App\Http\Controllers\ProductController@updateProduct');
    Route::get('/activateproduct/{id}', 'App\Http\Controllers\ProductController@activateProduct');
    Route::get('/deactivateproduct/{id}', 'App\Http\Controllers\ProductController@deactivateProduct');

    // Sliders controller routes
    Route::get('/sliders', 'App\Http\Controllers\SliderController@sliders');
    Route::get('/addslider', 'App\Http\Controllers\SliderController@addSlider');
    Route::post('/saveslider', 'App\Http\Controllers\SliderController@saveSlider');
    Route::get('/deleteslider/{id}', 'App\Http\Controllers\SliderController@deleteSlider');
    Route::get('/editslider/{id}', 'App\Http\Controllers\SliderController@editSlider');
    Route::post('/updateslider/{id}', 'App\Http\Controllers\SliderController@updateSlider');
    Route::get('/activateslider/{id}', 'App\Http\Controllers\SliderController@activateSlider');
    Route::get('/deactivateslider/{id}', 'App\Http\Controllers\SliderController@deactivateSlider');
});



/*
|--------------------------------------------------------------------------
| Any accessed links
|--------------------------------------------------------------------------
*/
// Client controller routes
Route::get('/', 'App\Http\Controllers\ClientController@home');
Route::get('/cart', 'App\Http\Controllers\ClientController@cart');
Route::get('/login', 'App\Http\Controllers\ClientController@login');
Route::post('/accessaccount', 'App\Http\Controllers\ClientController@accessAccount');
Route::get('/logout', 'App\Http\Controllers\ClientController@logout');
Route::get('/signup', 'App\Http\Controllers\ClientController@signup');
Route::post('/createaccount', 'App\Http\Controllers\ClientController@createAccount');
Route::get('/shop', 'App\Http\Controllers\ClientController@shop');
Route::get('/checkout', 'App\Http\Controllers\ClientController@checkout');
Route::post('/updateqty', 'App\Http\Controllers\ClientController@updateQty');
Route::post('/postceckout', 'App\Http\Controllers\ClientController@postCeckout');
Route::get('/showprofile/{id}', 'App\Http\Controllers\ClientController@showProfile');
Route::get('/editprofile/{id}', 'App\Http\Controllers\ClientController@editProfile');
Route::post('/updateprofile/{id}', 'App\Http\Controllers\ClientController@updateProfile');
Route::get('/removeitem/{id}', 'App\Http\Controllers\ClientController@removeItem');

// Admin controller routes
Route::get('/admin/login', 'App\Http\Controllers\AdminController@login');
Route::post('/admin/access', 'App\Http\Controllers\AdminController@accessAccount');
Route::get('/admin/logout', 'App\Http\Controllers\AdminController@logout');
Route::get('/deleteorder/{id}', 'App\Http\Controllers\AdminController@deleteOrder');

// Categories controller routes
Route::get('/shop/{name}', 'App\Http\Controllers\CategoryController@viewByCat');

// Products controller routes
Route::get('/addtocart/{id}', 'App\Http\Controllers\ProductController@addToCart');

// Pdf controller Routes
Route::get('/viewpdf/{id}', 'App\Http\Controllers\PdfController@viewPdf');


