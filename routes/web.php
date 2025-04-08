<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get ('/dashbord', function () {
    return view('dashbord');
})->middleware(['auth'])->name('dashbord');

// Admin Routes
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    // Admin Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');
    Route::group(['middleware' => ['admin']], function() {
        // Admin Dashboard Route
        Route::get('dashbord', 'AdminController@dashbord');
        // Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password', 'AdminController@updateAdminPassword'); 
        // Admin Logout
        Route::get('logout', 'AdminController@logout');
    });
});

// siham: dkchi mbghach ikhdm li flfo9
Route::match(['get', 'post'], 'admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('admin/dashbord', [AdminController::class, 'dashbord'])->middleware('admin')->name('admin.dashbord');
Route::get('admin/logout', [AdminController::class, 'logout'])->middleware('admin')->name('admin.logout');

// Update Admin Password
Route::match(['get', 'post'], 'update-admin-password', 'AdminController@updateAdminPassword'); 
Route::post('/admin/check-admin-password', [AdminController::class, 'checkAdminPassword'])
    ->middleware('admin')
    ->name('admin.check-admin-password');

// UPDATE ADMIN DETAILS
Route::post('check-admin-password', [AdminController::class, 'checkAdminPassword']);
Route::match(['get', 'post'], '/admin/update-admin-details', [AdminController::class, 'updateAdminDetails'])->name('admin.updateDetails');

// Update Vendor Details
Route::match(['get', 'post'], '/admin/update-vendor-details/{slug}', [AdminController::class, 'updateVendorDetails']);

// View Admins/Subadmins/Vendors
Route::get('admin/admins/{type?}', [AdminController::class, 'admins']);

// View Vendor Details
Route::get('admin/view-vendor-details/{id}', [AdminController::class, 'viewVendorDetails']);

//update admin status

Route::post('admin/update-admin-status', [AdminController::class, 'updateAdminStatus']);

