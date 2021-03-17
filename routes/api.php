<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
 

Route::post('create', [DataController::class, 'create']);
Route::get('post', [DataController::class, 'post']);
Route::get('edit/{id}', [DataController::class, 'edit']);
Route::post('edit', [DataController::class, 'edit_put']);
Route::delete('delete/{id}', [DataController::class, 'delete']);

});

