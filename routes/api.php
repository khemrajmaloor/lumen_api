<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// routes/api.php

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin register group routes
Route::group(['prefix' => 'api'], function () {
    Route::post('login', [AdminController::class, 'login']);
});
