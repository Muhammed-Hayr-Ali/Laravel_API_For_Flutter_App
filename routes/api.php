<?php

use App\Http\Controllers\API\address\AddressesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\ProfileController;
use App\Http\Controllers\API\Order\OrdersController;
use App\Http\Controllers\API\Products\ProductsController;
// My Middlewares
// auth:api
// UserBannedAuth
// UserBannedRequest
// ExpirationDateAuth
// ExpirationDateRequest



Route::prefix('auth')->group(function () {
    Route::post('checkMailAvailability', [AuthController::class, 'checkMailAvailability']);
    Route::post('sendVerificationCode', [AuthController::class, 'sendCode']);
    Route::post('completeRegistration', [AuthController::class, 'completeRegistration']);
    Route::middleware('UserBannedRequest')->post('login', [AuthController::class, 'login']);
    Route::middleware('UserBannedRequest')->post('continueWithGoogle', [AuthController::class, 'continueWithGoogle']);
    Route::middleware(['auth:api'])->post('logout', [AuthController::class, 'logout']);
});


Route::prefix('forgotPassword')->group(function () {
    Route::post('sendVerificationCode', [ForgotPasswordController::class, 'sendNewVerificationCode']);
    Route::post('verifyPhoneNumber', [ForgotPasswordController::class, 'verifyPhoneNumber']);
    Route::post('createNewPassword', [ForgotPasswordController::class, 'createNewPassword']);
});


Route::middleware(['auth:api', 'UserBannedAuth'])->prefix('profile')->group(function () {
    Route::post('getCurrentUser', [ProfileController::class, 'getCurrentUser']);
    Route::post('updateProfile', [ProfileController::class, 'updateProfile']);
    Route::post('logout', [ProfileController::class, 'logout']);
});





Route::middleware(['auth:api', 'UserBannedAuth'])->prefix('addresses')->group(function () {
    Route::get('getUserAddresses', [AddressesController::class, 'index']);
    Route::post('createNewAddress', [AddressesController::class, 'store']);
    Route::post('updateAddress', [AddressesController::class, 'update']);
    Route::post('deleteAddress', [AddressesController::class, 'destroy']);
    Route::post('setDefaultAddress', [AddressesController::class, 'setDefaultAddress']);
});



Route::middleware(['auth:api', 'UserBannedAuth'])->prefix('orders')->group(function () {
    Route::post('createNewOrder', [OrdersController::class, 'store']);
});

Route::middleware(['auth:api', 'UserBannedAuth'])->prefix('product')->group(function () {
    Route::post('createNewProduct', [ProductsController::class, 'store']);
});



