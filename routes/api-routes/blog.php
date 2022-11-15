<?php

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

Route::prefix("blogs")->group(function () {
    Route::post("", "BlogController@store");
    Route::get("categories", "BlogController@getCategories");
    Route::get("", "BlogController@getBlogs");
    Route::get("recent", "BlogController@getRecentBlogs");
    Route::post("update", "BlogController@update");
    Route::prefix("comments")->group(function () {
        Route::post("", "CommentController@createComment");
        Route::get("{blogId}", "CommentController@getComments");
        Route::delete("{id}", "CommentController@deleteComment");
    });
    Route::get("users", "BlogController@getAllUsers");
    Route::get("latest-users", "BlogController@getLatestUsers");
    Route::get("{id}", "BlogController@show");
});
