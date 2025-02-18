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
<<<<<<< HEAD
=======
/*
Route::get('/', function () {
    return view('welcome');
});

//Admin Dashbord without Admin ROute
Route::get('admin/dashbord','App/Http/Controllers/Admin/AdminController@dashbord');
*/

use App\Http\Controllers\Admin\AdminController;
//use Illuminate\Support\Facades\Route;
>>>>>>> 50aab4fabf412f4a495c0a559905bd2f2fab2cb1

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< HEAD
=======

/*
it doesn't work so we will use the manual one
Route::prefix('/admin')->group(function () {
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);
    Route::get('dashboard', [AdminController::class, 'dashboard']);
});
*/
// admin login (without the group thing  
Route::match(['get', 'post'], 'admin/login', [AdminController::class, 'login']);
// Admin Dashboard Route
Route::get('admin/dashbord', [AdminController::class, 'dashbord']);
>>>>>>> 50aab4fabf412f4a495c0a559905bd2f2fab2cb1
