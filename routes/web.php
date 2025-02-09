<?php
use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('react.index'); 
})->where('any', '^(?!js|css|images|fonts|favicon\.ico|logo).*');

// Serve static files like JS, CSS, images, etc.
Route::get('/react/{path}', function ($path) {
    $file = public_path("react/{$path}");
    if (file_exists($file)) {
        return response()->file($file);
    }

    abort(404); // If file doesn't exist
})->where('path', '.*');
