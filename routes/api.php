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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['cors'])->get('/user', function (Request $request) {
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
    Route::post(
        '/EditUser/{id_user}',
        [
            App\Http\Controllers\API\UserController::class,
            'editUserbyId'
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
        '/postinganbyUsername/{username}',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'getPostinganbyUsername'
        ]
    );
    Route::get(
        '/deletePostingan/{id_postingan}',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'deletePostinganbyId'
        ]
    );
    Route::get(
        '/getpostId/{id_postingan}',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'getPostinganbyId'
        ]
    );
    Route::post(
        '/editPostbyId/{id_postingan}',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'editPostinganbyId'
        ]
    );
    Route::get(
        '/search/{nama_pekerjaan}',
        [
            App\Http\Controllers\API\UploadPostinganController::class,
            'searchPostingan'
        ]
    );
});

Route::prefix('like')->group(function () {
    Route::get(
        '/tambahlike/{id_postingan}',
        [
            App\Http\Controllers\API\LikeController::class,
            'getLikebyId'
        ]
    );
    Route::post(
        '/likelagi',
        [
            App\Http\Controllers\API\LikeController::class,
            'createLike'
        ]
    );
    Route::get(
        '/likePost/{username}',
        [
            App\Http\Controllers\API\LikeController::class,
            'getLikebyUsername'
        ]
    );
});

Route::prefix('comment')->group(function () {
    Route::get(
        '/tambahcomment/{id_postingan}',
        [
            App\Http\Controllers\API\CommentController::class,
            'getCommentbyId'
        ]
    );
    Route::get(
        '/nextcomment/{id_comment}',
        [
            App\Http\Controllers\API\CommentController::class,
            'getCommentbyIdComment'
        ]
    );
    Route::post(
        '/tambahcommentlagi',
        [
            App\Http\Controllers\API\CommentController::class,
            'createComment'
        ]
    );
    Route::get(
        '/deleteComment/{id_comment}',
        [
            App\Http\Controllers\API\CommentController::class,
            'deletCommentbyId'
        ]
    );
});

Route::prefix('replycomment')->group(function () {
    Route::get(
        '/getreplycomment/{id_comment}',
        [
            App\Http\Controllers\API\ReplyCommentController::class,
            'getReplyCommentbyId'
        ]
    );
    Route::post(
        '/tambahreplycomment',
        [
            App\Http\Controllers\API\ReplyCommentController::class,
            'createReplyComment'
        ]
    );
    Route::get(
        '/deleteReplyComment/{id_replycomment}',
        [
            App\Http\Controllers\API\ReplyCommentController::class,
            'deletReplyCommentbyId'
        ]
    );
});

Route::prefix('simpan')->group(function () {
    Route::get(
        '/simpanPostingan/{username}',
        [
            App\Http\Controllers\API\SimpanPostinganController::class,
            'getSimpanbyId'
        ]
    );
    Route::post(
        '/createSimpanPost',
        [
            App\Http\Controllers\API\SimpanPostinganController::class,
            'createSimpan'
        ]
    );
    Route::get(
        '/simpanPost/{username}',
        [
            App\Http\Controllers\API\SimpanPostinganController::class,
            'getSimpanbyUsername'
        ]
    );
});

Route::prefix('notif')->group(function () {
    Route::get(
        '/getNotifikasi/{id_user}',
        [
            App\Http\Controllers\API\NotifikasiController::class,
            'readNotifikasi'
        ]
    );
});