<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Product;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//search
Route::get('/search',function(Request $request){

	$query = $request->get('query');
	$users = Product::where('name','like','%'.$query.'%')->get();
	return response()->json($users);
   });