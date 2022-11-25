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
use App\Http\Controllers\Admin\{AuthController,ProfileController,UserController, AuthorController, CategoriesController, ChaptersController, CommentsController, StoriesController};
use App\Http\Middleware\AdminAuth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class,'getLogin'])->name('getLogin');
Route::post('/admin/login',[AuthController::class,'postLogin'])->name('postLogin');
Route::get('/admin/register',[AuthController::class,'getRegister'])->name('getRegister');
Route::post('/admin/register',[AuthController::class,'postRegister'])->name('postRegister');
Route::middleware([AdminAuth::class])->group(function () {

// Route::group(['middleware'=>['admin_auth']],function(){
    Route::get('/admin/logout',[ProfileController::class,'logout'])->name('logout');
    Route::get('/admin/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/admin/users',[UserController::class,'index'])->name('users.index');
    Route::group(['prefix'=> 'admin/author'], function (){
        Route::get('/', [AuthorController::class,'index'])->name('author.index');
        Route::get('/dataTable',[AuthorController::class,'datatable'])->name('author.dataTable');
        Route::post('/store', [AuthorController::class,'store'])->name('author.store');
        Route::post('/update', [AuthorController::class,'update'])->name('author.update');
        Route::post('/destroy/{id}', [AuthorController::class,'destroy'])->name('author.destroy');
        Route::get('/show/{id}', [AuthorController::class,'show'])->name('author.show');
    });
});
