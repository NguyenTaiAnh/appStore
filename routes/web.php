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
use App\Http\Controllers\Admin\{AuthController,ProfileController,UserController, AuthorController, CategoriesController, ChaptersController, CommentsController, StoriesController,LevelsController};
use App\Http\Middleware\AdminAuth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class,'getLogin'])->name('getLogin');
Route::post('/admin/login',[AuthController::class,'postLogin'])->name('postLogin');
Route::get('/admin/register',[AuthController::class,'getRegister'])->name('getRegister');
Route::post('/admin/register',[AuthController::class,'postRegister'])->name('postRegister');
Route::middleware([AdminAuth::class])->group(function () {
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

    Route::group(['prefix'=> 'admin/categories'], function (){
        Route::get('/', [CategoriesController::class,'index'])->name('categories.index');
        Route::get('/dataTable',[CategoriesController::class,'datatable'])->name('categories.dataTable');
        Route::post('/store', [CategoriesController::class,'store'])->name('categories.store');
        Route::post('/update', [CategoriesController::class,'update'])->name('categories.update');
        Route::post('/destroy/{id}', [CategoriesController::class,'destroy'])->name('categories.destroy');
        Route::get('/show/{id}', [CategoriesController::class,'show'])->name('categories.show');
    });

    Route::group(['prefix'=> 'admin/levels'], function (){
        Route::get('/', [LevelsController::class,'index'])->name('levels.index');
        Route::get('/dataTable',[LevelsController::class,'datatable'])->name('levels.dataTable');
        Route::post('/store', [LevelsController::class,'store'])->name('levels.store');
        Route::post('/update', [LevelsController::class,'update'])->name('levels.update');
        Route::post('/destroy/{id}', [LevelsController::class,'destroy'])->name('levels.destroy');
        Route::get('/show/{id}', [LevelsController::class,'show'])->name('levels.show');
    });

    Route::group(['prefix'=> 'admin/stories'], function (){
        Route::get('/', [StoriesController::class,'index'])->name('stories.index');
        Route::get('/dataTable',[StoriesController::class,'datatable'])->name('stories.dataTable');
        Route::get('/create',[StoriesController::class,'create'])->name('stories.create');
        Route::post('/store', [StoriesController::class,'store'])->name('stories.store');
        Route::get('/edit/{id}', [StoriesController::class,'edit'])->name('stories.edit');
        Route::post('/update/{id}', [StoriesController::class,'update'])->name('stories.update');
        Route::post('/destroy/{id}', [StoriesController::class,'destroy'])->name('stories.destroy');
        Route::get('/show/{id}', [StoriesController::class,'show'])->name('stories.show');
        Route::get('/deleteImage/{id}',[StoriesController::class,'delImage'])->name('stories.delete.image');
    });
});
