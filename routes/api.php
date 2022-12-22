<?php

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{AuthController, StoriesController, ChapterController, CategoriesController};

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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


/**
 * middleware in file ApiBaseController
 * should no need declare middleware here
 */
Route::group(['prefix'=> '/v1'], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('profile','profile');
        Route::post('change-password','changePassWord');
        Route::get('test','test');
    });

    Route::group(['prefix' => 'stories'], function (){
        Route::get('',[StoriesController::class, 'index']);
        Route::get('increase_views',[StoriesController::class,'increaseViews']);
        Route::get('increase_follow',[StoriesController::class,'increaseFollow']);
        Route::get('increase_like',[StoriesController::class,'increaseLike']);
    });
    Route::group(['prefix' => 'chapters'], function (){
        Route::get('',[ChapterController::class, 'index']);
        Route::get('{id}',[ChapterController::class, 'detail']);
    });
    Route::group(['prefix'=> 'categories'],function (){
       Route::get('',[CategoriesController::class,'index']);
    });
});
