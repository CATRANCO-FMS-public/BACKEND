<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleAssignmentController;
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

        // User profile routes
        Route::prefix('profile')->group(function () {
            Route::get('view', [UserProfileController::class, 'viewOwnProfile']);
            Route::patch('update', [UserProfileController::class, 'updateOwnProfile']);
        });

        // Admin routes
        Route::middleware(['admin'])->prefix('admin')->group(function () {

            // Admin can create and manage users
            Route::prefix('users')->group(function () {
                Route::post('create', [UserController::class, 'createUser']);
                Route::get('all', [UserController::class, 'getAllUsers']);
                Route::get('{id}', [UserController::class,'getUserById']);
                Route::patch('update/{id}', [UserController::class, 'updateUser']);
                Route::delete('delete/{id}', [UserController::class, 'deleteUser']);
            });

            // Admin can create and manage user profiles
            Route::prefix('profiles')->group(function () {
                Route::post('create', [UserProfileController::class, 'createProfile']);
                Route::get('all', [UserProfileController::class, 'getAllProfiles']);
                Route::get('{id}', [UserProfileController::class, 'getProfileById']);
                Route::patch('update/{id}', [UserProfileController::class, 'updateProfile']);
                Route::delete('delete/{id}', [UserProfileController::class, 'deleteProfile']);
            });

            // Admin can create and manage vehicles
            Route::prefix('vehicles')->group(function () {
                Route::post('create', [VehicleController::class, 'createVehicle']);
                Route::get('all', [VehicleController::class, 'getAllVehicles']);
                Route::get('{id}', [VehicleController::class, 'getVehicleById']);
                Route::patch('update/{id}', [VehicleController::class, 'updateVehicle']);
                Route::delete('delete/{id}', [VehicleController::class, 'deleteVehicle']);
            });

            // Admin can create and manage vehicle assignments
            Route::prefix('assignments')->group(function () {
                Route::post('create', [VehicleAssignmentController::class, 'createAssignment']);
                Route::get('all', [VehicleAssignmentController::class, 'getAllAssignments']);
                Route::get('{id}', [VehicleAssignmentController::class, 'getAssignmentById']);
                Route::patch('update/{id}', [VehicleAssignmentController::class, 'updateAssignment']);
                Route::delete('delete/{id}', [VehicleAssignmentController::class, 'deleteAssignment']);
            });

        });

    });
});
