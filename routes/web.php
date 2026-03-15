<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperUserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/superuser', [SuperUserController::class, 'index'])->middleware('auth')->name('superuser');
Route::get('/superuser/audit', [SuperUserController::class, 'getAuditData'])->middleware('auth')->name('superuser.audit');
Route::get('/superuser/export', [SuperUserController::class, 'exportRegistry'])->middleware('auth')->name('superuser.export');
Route::post('/superuser/users', [SuperUserController::class, 'storeUser'])->middleware('auth')->name('superuser.users.store');
Route::put('/superuser/users/{user}', [SuperUserController::class, 'updateUser'])->middleware('auth')->name('superuser.users.update');
Route::delete('/superuser/users/{user}', [SuperUserController::class, 'deleteUser'])->middleware('auth')->name('superuser.users.delete');
Route::post('/superuser/users/{user}/kill-session', [SuperUserController::class, 'killSession'])->middleware('auth')->name('superuser.users.kill');
Route::get('/superuser/users/{user}/events', [SuperUserController::class, 'getUserEvents'])->middleware('auth')->name('superuser.users.events');
Route::put('/superuser/events/{event}', [SuperUserController::class, 'updateAdminEvent'])->middleware('auth')->name('superuser.events.update');
Route::delete('/superuser/events/{event}', [SuperUserController::class, 'deleteAdminEvent'])->middleware('auth')->name('superuser.events.delete');
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
