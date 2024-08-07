<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\FuelLogsController;
use App\Http\Controllers\DispatchLogsController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\MaintenanceSchedulingController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\FeedbackLogsController;
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

            // Admin can create and manage user profiles
            Route::prefix('profiles')->group(function () {
                Route::post('create', [UserProfileController::class, 'createProfile']);
                Route::get('all', [UserProfileController::class, 'getAllProfiles']);
                Route::get('{id}', [UserProfileController::class, 'getProfileById']);
                Route::patch('update/{id}', [UserProfileController::class, 'updateProfile']);
                Route::delete('delete/{id}', [UserProfileController::class, 'deleteProfile']);
            });

            // Admin can create and manage users
            Route::prefix('users')->group(function () {
                Route::post('create', [UserController::class, 'createUser']);
                Route::get('all', [UserController::class, 'getAllUsers']);
                Route::get('{id}', [UserController::class, 'getUserById']);
                Route::patch('update/{id}', [UserController::class, 'updateUser']);
                Route::delete('delete/{id}', [UserController::class, 'deleteUser']);
            });

            // Admin can create and manage vehicles
            Route::prefix('vehicles')->group(function () {
                Route::post('create', [VehicleController::class, 'createVehicle']);
                Route::get('all', [VehicleController::class, 'getAllVehicles']);
                Route::get('{id}', [VehicleController::class, 'getVehicleById']);
                Route::patch('update/{id}', [VehicleController::class, 'updateVehicle']);
                Route::delete('delete/{id}', [VehicleController::class, 'deleteVehicle']);
            });

            // Admin can create and manage fuel logs
            Route::prefix('fuel-logs')->group(function () {
                Route::post('create', [FuelLogsController::class, 'createFuelLog']);
                Route::get('all', [FuelLogsController::class, 'getAllFuelLogs']);
                Route::get('{id}', [FuelLogsController::class, 'getFuelLogById']);
                Route::patch('update/{id}', [FuelLogsController::class, 'updateFuelLog']);
                Route::delete('delete/{id}', [FuelLogsController::class, 'deleteFuelLog']);
            });

            // Admin can create and manage maintenance scheduling
            Route::prefix('maintenance-scheduling')->group(function () {
                Route::post('create', [MaintenanceSchedulingController::class, 'createMaintenanceScheduling']);
                Route::get('all', [MaintenanceSchedulingController::class, 'getAllMaintenanceScheduling']);
                Route::get('{id}', [MaintenanceSchedulingController::class, 'getMaintenanceSchedulingById']);
                Route::patch('update/{id}', [MaintenanceSchedulingController::class, 'updateMaintenanceScheduling']);
                Route::delete('delete/{id}', [MaintenanceSchedulingController::class, 'deleteMaintenanceScheduling']);
            });

            // Admin can create and manage vehicle assignments
            Route::prefix('assignments')->group(function () {
                Route::post('create', [VehicleAssignmentController::class, 'createAssignment']);
                Route::get('all', [VehicleAssignmentController::class, 'getAllAssignments']);
                Route::get('{id}', [VehicleAssignmentController::class, 'getAssignmentById']);
                Route::patch('update/{id}', [VehicleAssignmentController::class, 'updateAssignment']);
                Route::delete('delete/{id}', [VehicleAssignmentController::class, 'deleteAssignment']);
            });
            
            // Admin can view and delete dispatch logs
            Route::prefix('dispatch_logs')->group(function () {
                Route::get('all', [DispatchLogsController::class, 'getAllDispatchLogs']);
                Route::get('{id}', [DispatchLogsController::class, 'getDispatchLogById']);
                Route::delete('delete/{id}', [DispatchLogsController::class, 'deleteDispatchLog']);
            });

            // Admin can view and delete dispatch
            Route::prefix('dispatches')->group(function () {
                Route::get('all', [DispatchController::class, 'getAllDispatches']);
                Route::get('{id}', [DispatchController::class, 'getDispatchById']);
                Route::delete('delete/{id}', [DispatchController::class, 'deleteDispatch']);
            });

            // Admin can view and delete dispatch
            Route::prefix('feedbacks')->group(function () {
                Route::get('all', [FeedbackLogsController::class, 'getAllFeedbackLogs']);
                Route::get('{id}', [FeedbackLogsController::class, 'getFeedbackLogById']);
                Route::delete('delete/{id}', [FeedbackLogsController::class, 'deleteFeedbackLog']);
            });

        });


        // Dispatcher Routes
        Route::middleware(['dispatcher'])->prefix('dispatcher')->group(function () {

            // Dispatcher can create and manage dispatch logs
            Route::prefix('dispatch-logs')->group(function () {
                Route::post('create', [DispatchLogsController::class, 'createDispatchLog']);
                Route::get('all', [DispatchLogsController::class, 'getAllDispatchLogs']);
                Route::get('{id}', [DispatchLogsController::class, 'getDispatchLogById']);
                Route::patch('update/{id}', [DispatchLogsController::class, 'updateDispatchLog']);
                Route::delete('delete/{id}', [DispatchLogsController::class, 'deleteDispatchLog']);
            });

            // Dispatcher can create and manage dispatch logs
            Route::prefix('dispatches')->group(function () {
                Route::post('start', [DispatchController::class, 'startDispatch']);
                Route::get('all', [DispatchController::class, 'getAllDispatches']);
                Route::get('{id}', [DispatchController::class, 'getDispatchById']);
                Route::patch('update/{id}', [DispatchController::class, 'updateDispatch']);
                Route::patch('end/{id}', [DispatchController::class, 'endDispatch']);
                Route::patch('cancel/{id}', [DispatchController::class, 'cancelDispatch']);
                Route::delete('delete/{id}', [DispatchController::class, 'deleteDispatch']);
            });

        });

    }); 

    // OTP routes (public)
    Route::post('generate-otp', [OTPController::class, 'generateOTP']);
    Route::post('verify-otp', [OTPController::class, 'verifyOTP']);
    Route::get('show-otp', [OTPController::class, 'showOTP']);

    // Feedback logs routes (public)
    Route::post('submit-feedback', [FeedbackLogsController::class, 'createFeedbackLog']);
});
