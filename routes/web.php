<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\AdminController;



Route::get('/', function () {
    return view('welcome');
});



Route::get ('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
    
//require __DIR__. '/auth.php';
    
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    // Admin Login Route
    Route::match( ['get','post'],'login', 'AdminController@login');
    Route::group( ['middleware'=>['admin' ]], function(){
        // Admin Dashboard Route
        Route::get('dashboard','AdminController@dashbord');
        // Admin logout
        Route::get('logout','AdminController@logout');
    });
});

