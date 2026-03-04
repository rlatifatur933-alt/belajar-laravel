<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);

    // Handle employees 
    Route::resource('/employees', EmployeeController::class)->middleware(['role:Belajar Laravel']);

    // Handle departments 
    Route::resource('/departments', DepartmentController::class)->middleware(['role:Belajar Laravel']);

    // Handle roles
    Route::resource('/roles', RoleController::class)->middleware(['role:Belajar Laravel']);

    // Handle presences
    Route::resource('/presences', PresenceController::class)->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);

    // Handle payrolls
    Route::resource('/payrolls', PayrollController::class)->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);

    // Handle leave requests 
    Route::resource('/leave-requests', LeaveRequestController::class)->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);

    Route::get('/leave-requests/confirm/{id}', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm')->middleware(['role:Belajar Laravel']);
    Route::get('/leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject')->middleware(['role:Belajar Laravel']);

    // Handle tasks
    Route::resource('/tasks', TaskController::class)->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);
    Route::get('tasks/done/{id}', [TaskController::class, 'done'])->name('tasks.done')->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);
    Route::get('tasks/pending/{id}', [TaskController::class, 'pending'])->name('tasks.pending')->middleware(['role:Belajar Laravel,Developer,Sales,Data Entry']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
