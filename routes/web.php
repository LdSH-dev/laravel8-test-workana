<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\ForgotPasswordController;
use App\Http\Controllers\Authentication\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AddressController;

Route::get('/', [HomeController::class, 'index'])->middleware('auth:sanctum')->name('home');
Route::get('/api/lookup/{zip}', [AddressController::class, 'getAddress']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
Route::get('password/reset', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendReset'])->name('password.request.send');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');





