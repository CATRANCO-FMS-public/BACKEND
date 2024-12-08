<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Display the reset password form
Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');

// Handle the password reset (POST)
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');


