<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'registerAccount']);
    Route::post('login', [AuthController::class, 'loginAccount']);

    // Routes that require authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [AuthController::class, 'showUser']);
        Route::patch('update', [AuthController::class, 'updateAccount']);
        Route::post('logout', [AuthController::class, 'logoutAccount']);

        // Admin routes
        Route::middleware(['admin'])->prefix('admin')->group(function () {
            Route::get('all', [AdminController::class, 'getAllUsers']);
            Route::post('create', [AdminController::class, 'createUser']);
            Route::patch('update/{id}', [AdminController::class, 'updateUser']);
            Route::delete('delete/{id}', [AdminController::class, 'deleteUser']);

            // Admin can create and manage user profiles
            Route::post('profile/create', [UserProfileController::class, 'createProfile']);
            Route::patch('profile/update/{id}', [UserProfileController::class, 'updateProfile']);
            Route::delete('profile/delete/{id}', [UserProfileController::class, 'deleteProfile']);
            Route::get('profile/all', [UserProfileController::class, 'getAllProfiles']);
            Route::get('profile/{id}', [UserProfileController::class, 'getProfileById']);
        });

        // User profile routes
        Route::prefix('profile')->group(function () {
            Route::get('view', [UserProfileController::class, 'viewOwnProfile']);
            Route::patch('update', [UserProfileController::class, 'updateOwnProfile']);
        });
    });
});
