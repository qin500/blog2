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

Route::group(["as"=>'Home::'],function (){
    Route::get('/',[\App\Http\Controllers\home\IndexControl::class,"index"])->name('index');
    Route::get('/article/{article}',[\App\Http\Controllers\home\IndexControl::class,"article"])->name('article');
    Route::get('/tag/{name}',[\App\Http\Controllers\home\IndexControl::class,"tag"])->name('tag');
    Route::get('/category/{category}',[\App\Http\Controllers\home\IndexControl::class,"category"])->name('category');
    Route::get('/category/{category}',[\App\Http\Controllers\home\IndexControl::class,"category"])->name('category');
});
//
Route::match(["get",'post'],"/register",[\App\Http\Controllers\AuthController::class,"register"])->name('Auth::register');
Route::match(['get','post'],"/login",[\App\Http\Controllers\AuthController::class,"login"])->name('Auth::login');


Route::group(["as"=>'Admin::',"prefix" => "admin","middleware" => "ck"],function (){
    Route::get('/',[\App\Http\Controllers\admin\AdminController::class,"index"])->name('index');
    Route::post('/uploading',[\App\Http\Controllers\admin\AdminController::class,"uploading"])->name('uploading');

    Route::match(['get','post'],'logout',[\App\Http\Controllers\admin\AdminController::class,"logout"])->name('logout');

    Route::resource("article",\App\Http\Controllers\admin\ArticleController::class);
    Route::resource("category",\App\Http\Controllers\admin\CategoryController::class);
    Route::resource("tag",\App\Http\Controllers\admin\TagController::class);

    //生成七牛token
    Route::post('qngenerate_token',[\App\Http\Controllers\admin\AdminController::class,"qngenerate_token"])->name('qngenerate_token');



});
