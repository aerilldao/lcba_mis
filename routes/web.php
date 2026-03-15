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
Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->middleware('auth')->name('dashboard.events');
Route::post('/dashboard/events', [DashboardController::class, 'storeEvent'])->middleware('auth')->name('dashboard.events.store');
Route::put('/dashboard/events/{event}', [DashboardController::class, 'updateEvent'])->middleware('auth')->name('dashboard.events.update');
Route::delete('/dashboard/events/{event}', [DashboardController::class, 'deleteEvent'])->middleware('auth')->name('dashboard.events.delete');

Route::get('/checklist', function () {
    return view('checklist');
})->middleware('auth')->name('checklist');

Route::get('/basic-education', function () {
    return view('basic_education');
})->middleware('auth')->name('basic_education');

Route::get('/collegiate', function () {
    return view('collegiate');
})->middleware('auth')->name('collegiate');

Route::get('/basic-education-records', function () {
    return view('basic_education_records');
})->middleware('auth')->name('basic_education_records');

Route::get('/collegiate-records', function () {
    return view('collegiate_records');
})->middleware('auth')->name('collegiate_records');
