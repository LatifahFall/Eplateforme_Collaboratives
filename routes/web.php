<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;




Route::get('/', function () {
    return view('welcome');
});



Route::get ('/dashbord', function () {
    return view('dashbord');
})->middleware(['auth'])->name('dashbord');
require __DIR__. '\..\config\auth.php';
    
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    // Admin Login Route
    Route::match( ['get','post'],'login', 'AdminController@login');
    Route::group( ['middleware'=>['admin' ]], function(){
        // Admin Dashboard Route
        Route::get('dashbord','AdminController@dashbord');
        //Update Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword'); 
        // Admin logout
        Route::get('logout','AdminController@logout');
    });
});


// siham: dkchi mbghach ikhdm li flfo9
Route::match(['get', 'post'], 'admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('admin/dashbord', [AdminController::class, 'dashbord'])->middleware('admin')->name('admin.dashbord');
Route::get('admin/logout', [AdminController::class, 'logout'])->middleware('admin')->name('admin.logout');

//Route::post('check-admin-password','AdminController@checkAdminPassword');
//Update Admin Password
Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword'); 
Route::post('/admin/check-admin-password', [AdminController::class, 'checkAdminPassword'])
    ->middleware('admin')
    ->name('admin.check-admin-password');


