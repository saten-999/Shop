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
// Route::get('/{category}', function ($category) {
// 	return redirect('/all');
// });


Route::get('/', 'HomeController@latest');
// run this route to set first registered user  admin
Route::get('/first/set_first_admin', 'HomeController@setadmin');
Route::get('/first/migrate', 'HomeController@migrate');
Auth::routes();

Route::get('/home', 'HomeController@latest')->name('home');

Route::get('/{all}', 'HomeController@index');  //tested
Route::get('/all/all', 'HomeController@all');  //tested

Route::get('/all/{category}', 'HomeController@allproducts');  	//tested


Route::get('/cart/{id}', 'CartController@show');//tested                      ^
Route::get('/cart/{cart}/count/{count}', 'CartController@showvue');  //nuynna |


Route::get('/cart/delete/{id}', 'CartController@destroy'); 			//tested
Route::post('/cart/order', 'OrderController@store')->middleware('auth');  //tested
Route::get('/prod/cart', 'CartController@index');//tested
Route::get('/prod/whishlist', 'CartController@whishlist'); //tested
Route::get('/product/view/{product}', 'HomeController@show');
Route::get('/product/wishlist/{product}', 'HomeController@whishlist');//tested
Route::get('product/wishlist/delete/{product}', 'HomeController@destroy');//tested



Route::get('/prod/about', 'HomeController@about');//tested




Route::get('/profile/{user}', 'UserController@show');










Route::group(['middleware'  => ['auth','admin']], function() {


	Route::get('use/admin', 'Admin\DashboardController@index');



		// role of admin
	Route::get('/admin/role-register','Admin\DashboardController@registered');
	Route::get('/role-edit/{id}','Admin\DashboardController@registeredit');
	Route::put('/role-register-update/{id}','Admin\DashboardController@registerupdate');  //tested
    Route::delete('/role-delete/{id}','Admin\DashboardController@registerdelete');      //tested




			//products
    Route::get('/admin/products','Admin\ProductController@index');		//tested
    Route::post('/admin/products/add','Admin\ProductController@store');  //tested
    Route::get('/admin/products/{id}','Admin\ProductController@edit');	//tested
    Route::put('/admin/products/{id}','Admin\ProductController@update'); //tested
    Route::delete('/admin/products/{id}','Admin\ProductController@destroy'); //tested

			// category
	Route::get('/admin/category', 'Admin\CategoryController@index');	//tested
	Route::post('/admin/category', 'Admin\CategoryController@store'); //tested
	Route::get('/admin/category/{id}', 'Admin\CategoryController@edit'); //tested
	Route::put('/admin/category/{id}', 'Admin\CategoryController@update');//tested
	Route::delete('/admin/category/{id}', 'Admin\CategoryController@destroy');//tested




	Route::get('/admin/order', 'OrderController@index');
	Route::delete('/admin/order/{id}', 'OrderController@destroy');
});







// DB_CONNECTION=mysql
// DB_HOST=fdb29.awardspace.net
// DB_PORT=3306
// DB_DATABASE=3670921_learn
// DB_USERNAME=3670921_learn
// DB_PASSWORD=Abraham25.
