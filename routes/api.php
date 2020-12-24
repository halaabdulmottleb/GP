<?php

use App\Models\Bookables;
use App\Models\User;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::get('bookables', function(Request $request){
    return Bookables::all();
});

ROute::get('users', function(Request $req){
    return User::paginate(10);
});*/
//List users api/
Route::get('users' , 'App\Http\Controllers\userController@index');

//list single user 
Route::get('user/{id}' , 'App\Http\Controllers\userController@show');

//create new user
Route::post('user' , 'App\Http\Controllers\userController@store');

//update user
Route::put('user/{id}' ,'App\Http\Controllers\userController@store');

//Delete user
Route::delete('user/{id}' ,'App\Http\Controllers\userController@destroy');
//counter user
Route::get('counter' ,'App\Http\Controllers\userController@dataConter');
