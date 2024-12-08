<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\TrackerVehicleMappingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\FuelLogsController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\DispatchLogsController;
use App\Http\Controllers\MaintenanceSchedulingController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\FeedbackLogsController;
use App\Http\Controllers\FlespiController;
use Illuminate\Support\Facades\Route;

// Flespi Integration Route
Route::post('flespi-data', [FlespiController::class, 'handleData'])->middleware('custom.headers');

Route::prefix('user')->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'registerAccount']); //Check
    Route::post('login', [AuthController::class, 'loginAccount']); //Check
    Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink']);

    // Routes that require authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [AuthController::class, 'showUser']); //Check
        Route::patch('update', [AuthController::class, 'updateAccount']); //Check
        Route::post('logout', [AuthController::class, 'logoutAccount']); //Check

        // User profile routes
        Route::prefix('profile')->group(function () {
            Route::get('view', [UserProfileController::class, 'viewOwnProfile']); //Check
            Route::delete('{id}/delete-image', [UserProfileController::class, 'deleteUserProfileImage']); //Check
        });

        // Admin routes
        Route::middleware(['admin'])->prefix('admin')->group(function () {

            // Admin Update Own Profile
            Route::post('updateOwnProfile', [UserProfileController::class, 'updateOwnProfile']); //Check

            // Admin can activate and deactivate accounts
            Route::patch('/activate-account/{id}', [AuthController::class, 'activateAccount']);
            Route::patch('/deactivate-account/{id}', [AuthController::class, 'deactivateAccount']);

            // Admin can select the tracker for the vehicle
            Route::prefix('tracker-vehicle')->group(function() {
                Route::get('all', [TrackerVehicleMappingController::class, 'getAllTrackerVehicleMappings']);
                Route::post('create', [TrackerVehicleMappingController::class, 'createTrackerVehicleMapping']);
                Route::put('update/{id}', [TrackerVehicleMappingController::class, 'updateTrackerVehicleMapping']);
                Route::delete('delete/{id}', [TrackerVehicleMappingController::class, 'deleteTrackerVehicleMapping']);
            });
        
            // Admin can create and manage user profiles and user accounts
            Route::prefix('profiles')->group(function () {
                // General Profile Management
                Route::post('create', [UserProfileController::class, 'createProfile']); //Check
                Route::get('all', [UserProfileController::class, 'getAllProfiles']); //Check
                Route::get('{id}', [UserProfileController::class, 'getProfileById']); //Check
                Route::patch('update/{id}', [UserProfileController::class, 'updateProfile']); //Check
                Route::delete('delete/{id}', [UserProfileController::class, 'deleteProfile']); //Check

                // Profiles grouped by position
                Route::prefix('position')->group(function () {
                    Route::get('drivers', [UserProfileController::class, 'getDriver']); // Fetch all drivers
                    Route::get('passenger-assistant-officers', [UserProfileController::class, 'getPSO']); // Fetch all Passenger Assistant Officers
                });
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
                Route::post('update/{id}', [FuelLogsController::class, 'updateFuelLog']); //Check
                Route::delete('delete/{id}', [FuelLogsController::class, 'deleteFuelLog']); //Check
            });

            // Admin can create and manage maintenance scheduling
            Route::prefix('maintenance-scheduling')->group(function () {
                Route::post('create', [MaintenanceSchedulingController::class, 'createMaintenanceScheduling']); //Check
                Route::get('all', [MaintenanceSchedulingController::class, 'getAllMaintenanceScheduling']); //Check
                Route::get('{id}', [MaintenanceSchedulingController::class, 'getMaintenanceSchedulingById']); //Check
                Route::patch('update/{id}', [MaintenanceSchedulingController::class, 'updateMaintenanceScheduling']); //Check
                Route::delete('delete/{id}', [MaintenanceSchedulingController::class, 'deleteMaintenanceScheduling']); //Check
                Route::post('toggle-status/{id}', [MaintenanceSchedulingController::class, 'toggleMaintenanceStatus']); //Check

                    Route::get('all/active', [MaintenanceSchedulingController::class, 'getAllActiveMaintenance']);
                    Route::get('all/completed', [MaintenanceSchedulingController::class, 'getAllCompletedMaintenance']);
            });

            // Admin can view and delete dispatch
            Route::prefix('dispatch_logs')->group(function () {
                Route::get('all', [DispatchLogsController::class, 'getAllDispatches']);
                Route::get('{id}', [DispatchLogsController::class, 'getDispatchById']);
                Route::delete('delete', [DispatchLogsController::class, 'deleteRecords']);
            });

            // Admin can view and delete feedbacks
            Route::prefix('feedbacks')->group(function () {
                Route::get('all', [FeedbackLogsController::class, 'getAllFeedbackLogs']); //Check
                Route::get('{id}', [FeedbackLogsController::class, 'getFeedbackLogById']); //Check
                Route::delete('delete/{id}', [FeedbackLogsController::class, 'deleteFeedbackLog']); //Check
            });

        });


        // Dispatcher Routes
        Route::middleware(['dispatcher'])->prefix('dispatcher')->group(function () {

            // Dispatcher can add their profile image
            Route::post('updateProfileImage', [UserProfileController::class, 'updateProfileImage']); //Check

            // Dispatcher can view vehicle assignments
            Route::prefix('assignments')->group(function () {
                Route::get('all', [VehicleAssignmentController::class, 'getAllAssignments']); //Check
                Route::get('{id}', [VehicleAssignmentController::class, 'getAssignmentById']); //Check
            });

            // Dispatcher can create and manage timers
            Route::prefix('timers')->group(function () {
                Route::get('all', [TimerController::class, 'getAllTimers']); // Fetch all timers
                Route::get('{id}', [TimerController::class, 'getTimerById']); // Fetch a timer by ID
                Route::post('create', [TimerController::class, 'createTimer']); // Create a timer
                Route::patch('update/{id}', [TimerController::class, 'updateTimer']); // Update a timer by ID
                Route::delete('delete/{id}', [TimerController::class, 'deleteTimer']); // Delete a timer by ID
            });

            // Dispatcher can create and manage dispatch logs
            Route::prefix('dispatch_logs')->group(function () {
                Route::post('alley/start', [DispatchLogsController::class, 'startAlley']);
                Route::post('dispatch/start', [DispatchLogsController::class, 'startDispatch']); 
                Route::get('all', [DispatchLogsController::class, 'getAllDispatches']); 
                Route::get('{id}', [DispatchLogsController::class, 'getDispatchById']); 
                Route::patch('alley/end/{id}', [DispatchLogsController::class, 'endAlley']); 
                Route::patch('dispatch/end/{id}', [DispatchLogsController::class, 'endDispatch']);
            });
        });
    }); 

    Route::post('/feedback', [FeedbackLogsController::class, 'createFeedbackLog']); //Check
    Route::post('/otp/generate', [OTPController::class, 'generateOTP']); //Check
    Route::post('/feedback/{feedback_logs_id}/verify-phone', [FeedbackLogsController::class, 'verifyPhoneNumber']); //Check
});
