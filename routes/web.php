<?php

use App\Http\Controllers\admin\AdminPostController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\users\PostController;
use App\Http\Controllers\users\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get("/home",function(){
    return view("welcome");
})->name("home");
Route::middleware("guest")->group(function(){
    Route::get('/',[AuthController::class,"index"])->name("index");
    Route::get('/login',[AuthController::class,"login"])->name("login");
    Route::post('/login',[AuthController::class,"ensurelogin"])->name("login.ensure");
    Route::get('/register',[AuthController::class,"register"])->name("register");
    Route::post('/register',[AuthController::class,"ensureregister"])->name("register.ensure");
});

Route::get('/client/home',[UserController::class,"home"])->name("user.home")->middleware("UserAuth");
Route::prefix("/client")->middleware("UserAuth")->group(function(){
    Route::get('/user/{userid}/edit',[UserController::class,"edit"])->name("user.edit");
    Route::put('/user/{userid}',[UserController::class,"update"])->name("user.update");
    Route::delete('/user/{userid}',[UserController::class,"destroy"])->name("user.destroy");
    Route::get("/profile",[UserController::class,"profile"])->name("user.profile");
    Route::resource("post",PostController::class);
});


Route::get('/admin/home',[AdminUserController::class,"home"])->name("admin.home")->middleware("AdminAuth");
Route::prefix("/admin")->middleware("AdminAuth")->group(function(){
    Route::get("/dashboard",[AdminUserController::class,"dashboard"])->name("admin.dashboard");
    Route::get("/profile",[AdminUserController::class,"profile"])->name("admin.profile");
    Route::resource("users",AdminUserController::class);
    Route::resource("posts",AdminPostController::class);
    Route::delete("/deleteuser/{id}",[AdminUserController::class,"deleteuser"])->name("users.deleteuser");
    Route::delete("/deleteuserclear",[AdminUserController::class,"clear"])->name("users.clear");
    Route::delete("/deletepostclear",[AdminPostController::class,"clear"])->name("posts.clear");
});
Route::match(['get','post'],'/logout',[AuthController::class,"logout"])->name("logout");


