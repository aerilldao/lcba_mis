<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/dashboard/notes', [DashboardController::class, 'updateNotes'])->middleware('auth')->name('dashboard.notes');

Route::get('/checklist', function () {
    return view('checklist');
})->middleware('auth')->name('checklist');
