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

Route::prefix("auth")->group(function () {
    Route::post("register", "AuthController@register");
    Route::post("login", "AuthController@login");
    Route::get("logout", "AuthController@logout");
    Route::get("cities-with-areas", "AuthController@getCitiesWithAreas");
    Route::get('current-user', "AuthController@getCurrentUser");
    Route::get("verify-token", "EmailVerificationController@verifyToken");
    Route::post("verify-email", "EmailVerificationController@verifyEmail");
    Route::get("resend-verification-code", "EmailVerificationController@resendVerificationCode");
    Route::get("user-verified", "EmailVerificationController@userVerified");
    Route::get('forget-password/{email}', "ForgetPasswordController@forgetPassword");
    Route::post('reset-password', "ForgetPasswordController@resetPassword");
    Route::post('update-profile', "ProfileController@updateProfile");
});
