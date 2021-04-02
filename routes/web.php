<?php

use Illuminate\Support\Facades\Route;





Route::get('/', 'HomeController@latest');
Auth::routes();


Route::get('/home', 'HomeController@latest')->name('home');                    //tested
Route::get('/{all}', 'HomeController@index');  
Route::get('/all/all', 'HomeController@all');                                  //tested
Route::get('/all/{category}', 'HomeController@allproducts');				   //tested



Route::get('/cart/{id}', 'CartController@show');                              //tested  ^
Route::get('/cart/{cart}/count/{count}', 'CartController@showvue');            //nuynna |
Route::get('/cart/delete/{id}', 'CartController@destroy'); 			           //tested
Route::post('/cart/order', 'OrderController@store')->middleware('auth');       //tested

Route::get('/prod/cart', 'CartController@index') ;                             //tested
Route::get('/prod/whishlist', 'CartController@whishlist');                     //tested
Route::get('/product/view/{product}', 'HomeController@show');                  //tested
Route::get('/product/wishlist/{product}', 'HomeController@whishlist');         //tested
Route::get('/product/wishlist/delete/{product}', 'HomeController@destroy');    //tested


Route::get('/chat/onlineadmin', 'MessageController@onlineadmin');




Route::get('/prod/about', 'HomeController@about');//tested
Route::get('/profile/{user}', 'UserController@show');

Route::get('/chat/chat', 'MessageController@index');



Route::group(['middleware'  => ['auth']], function() {

	Route::get('/admin/chat', 'MessageController@adminchat');
	Route::get('/admin/contacts', 'MessageController@get');
	Route::get('/admin/conversation/{id}', 'MessageController@getmessagesfor');
	Route::post('/admin/conversation/send', 'MessageController@send');
	Route::put('/admin/conversation/update/{id}/{auth_id}', 'MessageController@updatemessage');
	Route::get('/chat/unreadcount/{id}', 'MessageController@unreadcount');
});





Route::group(['middleware'  => ['auth','admin']], function() {


	Route::get('/use/admin', 'Admin\DashboardController@index');      //tested



		// role of admin
	Route::get('/admin/role-register','Admin\DashboardController@registered');			  //tested
	Route::get('/role-edit/{id}','Admin\DashboardController@registeredit');               //tested
	Route::put('/role-register-update/{id}','Admin\DashboardController@registerupdate');  //tested
    Route::delete('/role-delete/{id}','Admin\DashboardController@registerdelete');        //tested




			//products
    Route::get('/admin/products','Admin\ProductController@index');				//tested
    Route::post('/admin/products/add','Admin\ProductController@store');  		//tested
    Route::get('/admin/products/{id}','Admin\ProductController@edit');			//tested
    Route::put('/admin/products/{id}','Admin\ProductController@update'); 		//tested
    Route::delete('/admin/products/{id}','Admin\ProductController@destroy'); 	//tested

			// category
	Route::get('/admin/category', 'Admin\CategoryController@index');			//tested
	Route::post('/admin/category', 'Admin\CategoryController@store'); 			//tested
	Route::get('/admin/category/{id}', 'Admin\CategoryController@edit'); 		//tested
	Route::put('/admin/category/{id}', 'Admin\CategoryController@update');		//tested
	Route::delete('/admin/category/{id}', 'Admin\CategoryController@destroy');	//tested

	
	Route::get('/admin/order', 'OrderController@index');    					//tested
	Route::delete('/admin/order/{id}', 'OrderController@destroy');				//tested


	
});








