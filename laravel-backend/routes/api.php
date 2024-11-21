<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\FuelLogsController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\MaintenanceSchedulingController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\FeedbackLogsController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'registerAccount']); //Check
    Route::post('login', [AuthController::class, 'loginAccount']); //Check

    // Routes that require authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [AuthController::class, 'showUser']); //Check
        Route::patch('update', [AuthController::class, 'updateAccount']); //Check
        Route::post('logout', [AuthController::class, 'logoutAccount']); //Check

        // User profile routes
        Route::prefix('profile')->group(function () {
            Route::get('view', [UserProfileController::class, 'viewOwnProfile']); //Check
            Route::patch('update', [UserProfileController::class, 'updateOwnProfile']); //Check
        });

        // Admin routes
        Route::middleware(['admin'])->prefix('admin')->group(function () {

            Route::patch('/activate-account/{id}', [AuthController::class, 'activateAccount']);
            Route::patch('/deactivate-account/{id}', [AuthController::class, 'deactivateAccount']);

            // Admin can create and manage user profiles and user accounts
            Route::prefix('profiles')->group(function () {
                Route::post('create', [UserProfileController::class, 'createProfile']); //Check
                Route::get('all', [UserProfileController::class, 'getAllProfiles']); //Check
                Route::get('{id}', [UserProfileController::class, 'getProfileById']); //Check
                Route::patch('update/{id}', [UserProfileController::class, 'updateProfile']); //Check
                Route::delete('delete/{id}', [UserProfileController::class, 'deleteProfile']); //Check
            });

            // Admin can create and manage vehicles
            Route::prefix('vehicles')->group(function () {
                Route::post('create', [VehicleController::class, 'createVehicle']); //Check
                Route::get('all', [VehicleController::class, 'getAllVehicles']); //Check
                Route::get('{id}', [VehicleController::class, 'getVehicleById']); //Check
                Route::patch('update/{id}', [VehicleController::class, 'updateVehicle']); //Check
                Route::delete('delete/{id}', [VehicleController::class, 'deleteVehicle']); //Check
            });

            // Admin can create and manage vehicle assignments
            Route::prefix('assignments')->group(function () {
                Route::post('create', [VehicleAssignmentController::class, 'createAssignment']); //Check
                Route::get('all', [VehicleAssignmentController::class, 'getAllAssignments']); //Check
                Route::get('{id}', [VehicleAssignmentController::class, 'getAssignmentById']); //Check
                Route::patch('update/{id}', [VehicleAssignmentController::class, 'updateAssignment']); //Check
                Route::delete('delete/{id}', [VehicleAssignmentController::class, 'deleteAssignment']); //Check
            });

            // Admin can create and manage fuel logs
            Route::prefix('fuel-logs')->group(function () {
                Route::post('create', [FuelLogsController::class, 'createFuelLog']); //Check
                Route::get('all', [FuelLogsController::class, 'getAllFuelLogs']); //Check
                Route::get('{id}', [FuelLogsController::class, 'getFuelLogById']); //Check
                Route::patch('update/{id}', [FuelLogsController::class, 'updateFuelLog']); //Check
                Route::delete('delete/{id}', [FuelLogsController::class, 'deleteFuelLog']); //Check
            });

            // Admin can create and manage maintenance scheduling
            Route::prefix('maintenance-scheduling')->group(function () {
                Route::post('create', [MaintenanceSchedulingController::class, 'createMaintenanceScheduling']); //Check
                Route::get('all', [MaintenanceSchedulingController::class, 'getAllMaintenanceScheduling']); //Check
                Route::get('{id}', [MaintenanceSchedulingController::class, 'getMaintenanceSchedulingById']); //Check
                Route::patch('update/{id}', [MaintenanceSchedulingController::class, 'updateMaintenanceScheduling']); //Check
                Route::delete('delete/{id}', [MaintenanceSchedulingController::class, 'deleteMaintenanceScheduling']); //Check
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
        
        // // Driver Routes
        // Route::middleware(['driver'])->prefix('driver')->group(function () {
        //     Route::post('updateReturn', [VehicleAssignmentController::class, 'updateReturnDate']);
        // });        
        
    }); 

    Route::post('/feedback', [FeedbackLogsController::class, 'createFeedbackLog']);
    Route::post('/otp/generate', [OTPController::class, 'generateOTP']);
    Route::post('/feedback/{feedback_logs_id}/verify-phone', [FeedbackLogsController::class, 'verifyPhoneNumber']);
});
