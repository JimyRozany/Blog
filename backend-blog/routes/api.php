<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Post\LikeController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Post\CommentController;

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


Route::middleware('checkApiPassword')->group(function(){

    // ---------- user -----------
    Route::prefix('user')->group(function(){
        Route::post('register' ,[UserController::class ,'userRegister']);
        Route::post('login' ,[UserController::class ,'userLogin']);
        // Route::post('logout' ,[UserController::class ,'userLogout'])->middleware(['auth:user-api','jwtCheckAuth']);
        Route::post('logout' ,[UserController::class ,'userLogout'])->middleware(['checkAuthAndToken:user-api']);
    });

    // ---------- admin -----------
    Route::prefix('admin')->group(function(){
        Route::post('register' ,[AdminController::class ,'adminRegister']);
        Route::post('login' ,[AdminController::class ,'adminLogin']);
        Route::post('logout' ,[AdminController::class ,'adminLogout'])->middleware(['checkAuthAndToken:admin-api']);
    });

    // ---------- post -----------
    Route::post('posts' ,[PostController::class ,'index']); // get all posts
    Route::prefix('post')->middleware([ 'checkAuthAndToken:user-api'])->group(function(){
        Route::post('create' ,[PostController::class ,'store']); // create post
        Route::post('show' ,[PostController::class ,'show']); // show post  , get one post by id
        Route::post('update' ,[PostController::class ,'update']); // update post
        Route::post('delete' ,[PostController::class ,'destroy']); // delete post

    });
    // ---------- comments -----------
    Route::post('comments' ,[CommentController::class ,'index']);
    Route::prefix('comment')->middleware([ 'checkAuthAndToken:user-api'])->group(function(){
        
        Route::post('create' ,[CommentController::class ,'store']); // create comment
        Route::post('update' ,[CommentController::class ,'update']); // update comment
        Route::post('delete' ,[CommentController::class ,'destroy']); // delete comment

    });

    // ---------- likes -----------
    Route::middleware([ 'checkAuthAndToken:user-api'])->group(function(){
        Route::post('like' ,[LikeController::class ,'like']); // add like
        // Route::post('like' ,[CommentController::class ,'like']); // remove like

    });

    
});