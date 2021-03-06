<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
    Route::post(
        '/register',
        [
            App\Http\Controllers\API\UserController::class,
            'register'
        ]
    );
    Route::post(
        '/login',
        [
            App\Http\Controllers\API\UserController::class,
            'login'
        ]
    );
});

Route::prefix('uploadPostingan')->group(function () {
    Route::post(
        '/upload',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'newPostingan'
        ]
    );
    Route::get(
        '/postingan',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'readPostingan'
        ]
    );
    Route::get(
        '/postinganbyUser/{username}',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'getPostingandbyUser'
        ]
    );
});
