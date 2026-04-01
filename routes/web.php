<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SuperUserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/dashboard/notes', [DashboardController::class, 'updateNotes'])->middleware('auth')->name('dashboard.notes');
Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->middleware('auth')->name('dashboard.events');
Route::post('/dashboard/events', [DashboardController::class, 'storeEvent'])->middleware('auth')->name('dashboard.events.store');
Route::put('/dashboard/events/{event}', [DashboardController::class, 'updateEvent'])->middleware('auth')->name('dashboard.events.update');
Route::delete('/dashboard/events/{event}', [DashboardController::class, 'deleteEvent'])->middleware('auth')->name('dashboard.events.delete');

Route::get('/checklist', function () {
    return view('checklist');
})->middleware('auth')->name('checklist');

Route::get('/checklist/lookup-student', [ChecklistController::class, 'lookupStudent'])->middleware('auth')->name('checklist.lookup');
Route::post('/checklist/save', [ChecklistController::class, 'saveChecklist'])->middleware('auth')->name('checklist.save');
Route::post('/checklist/finish-basic', [ChecklistController::class, 'finishBasicEducation'])->middleware('auth')->name('checklist.finish.basic');
Route::post('/checklist/finish-collegiate', [ChecklistController::class, 'finishCollegiate'])->middleware('auth')->name('checklist.finish.collegiate');

Route::get('/basic-education', [ChecklistController::class, 'basicEducationForm'])->middleware('auth')->name('basic_education');
Route::get('/collegiate', [ChecklistController::class, 'collegiateForm'])->middleware('auth')->name('collegiate');

Route::get('/basic-education-records', [RecordController::class, 'basicEducationRecords'])->middleware('auth')->name('basic_education_records');
Route::get('/basic-education-records/print/{id}', [RecordController::class, 'printBasicEducation'])->middleware('auth')->name('basic_education.print');
Route::get('/collegiate-records', [RecordController::class, 'collegiateRecords'])->middleware('auth')->name('collegiate_records');
Route::get('/collegiate-records/print/{id}', [RecordController::class, 'printCollegiate'])->middleware('auth')->name('collegiate.print');
