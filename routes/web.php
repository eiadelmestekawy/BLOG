<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostsController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Website\CategoryController as WebsiteCategoryController;
use Illuminate\Routing\Route as IlluminateRoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Route as RoutingRoute;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//website

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/categories/{category}', [WebsiteCategoryController::class, 'show'])->name('category');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post');

// Route::get('/', function () {
//     return view('dashboard.index');
// });


// Route::prefix('dashboard')->group(function () {
//     route::get('/settings', function(){
//         return view('dashboard.settings');
//     })->name('dashboard.settings');
// });




//dashboard

route::group(['prefix'=>'dashboard', 'as'=>'dashboard.', 'middleware'=>['auth', 'CheckLogin']],function(){
    route::get('/', function(){
        return view('dashboard.layouts.layout');
    })->name('index');

    route::get('/settings', [SettingController::class , 'index'])->name('settings');

    route::post('/settings/update/{setting}',[SettingController::class , 'update'])->name('settings.update');
    
    route::get('/users/all',[UserController::class , 'getUsersDatatable'])->name('users.all');
    route::post('/users/delete',[UserController::class , 'delete'])->name('users.delete');
    
    route::get('/category/all',[CategoryController::class , 'getCategoriesDatatable'])->name('category.all');
    route::post('/category/delete',[CategoryController::class , 'delete'])->name('category.delete');
    
    route::get('/posts/all',[PostsController::class , 'getPostsDatatable'])->name('posts.all');
    route::post('/posts/delete',[PostsController::class , 'delete'])->name('posts.delete');

    Route::resources([
        'users' => UserController::class,
        'category' => CategoryController::class,
        'posts' => PostsController::class,
    ]);
    
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::post('/settings/update/{setting}', [SettingController::class , 'update'])->name('settings.update');