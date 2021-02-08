<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Categories accessed links
|--------------------------------------------------------------------------
*/
Route::get('/categories', 'App\Http\Controllers\api\CategoryController@categories');
Route::get('/category/{id}', 'App\Http\Controllers\api\CategoryController@category');
Route::post('/category/store', 'App\Http\Controllers\api\CategoryController@storeCategory');
Route::post('/category/update/{id}', 'App\Http\Controllers\api\CategoryController@updateCategory');
Route::get('/category/delete/{id}', 'App\Http\Controllers\api\CategoryController@deleteCategory');

/*
|--------------------------------------------------------------------------
| Admin accessed links
|--------------------------------------------------------------------------
*/
Route::post('/admin/login', 'App\Http\Controllers\api\AdminController@accessAcount');
Route::get('/admin/logout', 'App\Http\Controllers\api\AdminController@logout');
Route::get('/admin/orders', 'App\Http\Controllers\api\AdminController@orders');
Route::get('/admin/clients', 'App\Http\Controllers\api\AdminController@clients');
Route::get('/admin/order/{id}', 'App\Http\Controllers\api\AdminController@order');
Route::get('/admin/client/{id}', 'App\Http\Controllers\api\AdminController@client');
Route::get('/admin/delete/order/{id}', 'App\Http\Controllers\api\AdminController@deleteOrder');
Route::get('/admin/delete/client/{id}', 'App\Http\Controllers\api\AdminController@deleteClient');
Route::get('/admin/setadmin/{id}', 'App\Http\Controllers\api\AdminController@setAdmin');
Route::get('/admin/removeadmin/{id}', 'App\Http\Controllers\api\AdminController@removeAdmin');

/*
|--------------------------------------------------------------------------
| Product accessed links
|--------------------------------------------------------------------------
*/
Route::get('/products', 'App\Http\Controllers\api\ProductController@products');
Route::post('/product/save', 'App\Http\Controllers\api\ProductController@saveProduct');
Route::get('/product/{id}', 'App\Http\Controllers\api\ProductController@product');
Route::post('/product/update/{id}', 'App\Http\Controllers\api\ProductController@updateProduct');
Route::get('/product/activeate/{id}', 'App\Http\Controllers\api\ProductController@activateProduct');
Route::get('/product/deactiveate/{id}', 'App\Http\Controllers\api\ProductController@deactivateProduct');
Route::get('/product/delete/{id}', 'App\Http\Controllers\api\ProductController@deleteProduct');

/*
|--------------------------------------------------------------------------
| Slider accessed links
|--------------------------------------------------------------------------
*/
Route::get('/sliders', 'App\Http\Controllers\api\SiderController@sliders');
Route::post('/slider/save', 'App\Http\Controllers\api\SiderController@saveSlider');
Route::get('/slider/{id}', 'App\Http\Controllers\api\SiderController@slider');
Route::post('/slider/update/{id}', 'App\Http\Controllers\api\SiderController@updateSlider');
Route::get('/slider/activeate/{id}', 'App\Http\Controllers\api\SiderController@activateSlider');
Route::get('/slider/deactiveate/{id}', 'App\Http\Controllers\api\SiderController@deactivateSlider');
Route::get('/slider/delete/{id}', 'App\Http\Controllers\api\SiderController@deleteSlider');

/*
|--------------------------------------------------------------------------
| Clients accessed links
|--------------------------------------------------------------------------
*/
Route::get('/clients', 'App\Http\Controllers\api\ClientController@clients');
Route::post('/client/save', 'App\Http\Controllers\api\ClientController@saveClient');
Route::get('/client/{id}', 'App\Http\Controllers\api\ClientController@client');
Route::post('/client/update/{id}', 'App\Http\Controllers\api\ClientController@updateClient');

