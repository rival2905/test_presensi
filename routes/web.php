<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AttendanceRecordController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventScheduleController;
use App\Http\Controllers\Admin\EventRegistrationController;
use App\Http\Controllers\Admin\PaymentController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
});

Auth::routes();

// ==================
// ADMIN ROUTES
// ==================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Permissions
    Route::resource('permission', PermissionController::class, [
        'except' => ['show', 'create', 'edit', 'update', 'delete'],
    ]);

    // Roles
    Route::resource('role', RoleController::class, [
        'except' => ['show'],
    ]);

    // Users
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Main & Sub Categories
    Route::resource('maincategories', MainCategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);

    // activites
    Route::resource('activities', ActivityController::class);

    // payments
    Route::resource('payments', PaymentController::class);


   // Event Schedules
Route::prefix('schedules')->name('schedules.')->group(function () {
    Route::get('/', [EventScheduleController::class, 'index'])
        ->name('index')
        ->middleware('can:schedules.index');

    Route::get('/create', [EventScheduleController::class, 'create'])
        ->name('create')
        ->middleware('can:schedules.create');

    Route::post('/', [EventScheduleController::class, 'store'])
        ->name('store')
        ->middleware('can:schedules.create');

    Route::get('/{id}/edit', [EventScheduleController::class, 'edit'])
        ->name('edit')
        ->middleware('can:schedules.edit');

    Route::put('/{id}', [EventScheduleController::class, 'update'])
        ->name('update')
        ->middleware('can:schedules.edit');

    Route::delete('/{id}', [EventScheduleController::class, 'destroy'])
        ->name('destroy')
        ->middleware('can:schedules.delete');
});

    // Event Registrations
Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::get('/', [EventRegistrationController::class, 'index'])
        ->name('index')
        ->middleware('can:registrations.index');

    Route::get('/create', [EventRegistrationController::class, 'create'])
        ->name('create')
        ->middleware('can:registrations.create');

    Route::post('/', [EventRegistrationController::class, 'store'])
        ->name('store')
        ->middleware('can:registrations.create');

    Route::get('/{id}/edit', [EventRegistrationController::class, 'edit'])
        ->name('edit')
        ->middleware('can:registrations.edit');

    Route::put('/{id}', [EventRegistrationController::class, 'update'])
        ->name('update')
        ->middleware('can:registrations.edit');

    Route::delete('/{id}', [EventRegistrationController::class, 'destroy'])
        ->name('destroy')
        ->middleware('can:registrations.delete');
});

    // Attendance Records
    Route::prefix('attendance-records')->name('attendance-records.')->group(function () {
    Route::get('/', [AttendanceRecordController::class, 'index'])->name('index')->middleware('can:attendances.index');
    Route::get('/create', [AttendanceRecordController::class, 'create'])->name('create')->middleware('can:attendances.create');
    Route::post('/', [AttendanceRecordController::class, 'store'])->name('store')->middleware('can:attendances.create');
    Route::get('/{id}/edit', [AttendanceRecordController::class, 'edit'])->name('edit')->middleware('can:attendances.edit');
    Route::put('/{id}', [AttendanceRecordController::class, 'update'])->name('update')->middleware('can:attendances.edit');
    Route::delete('/{id}', [AttendanceRecordController::class, 'destroy'])->name('destroy')->middleware('can:attendances.delete');
});

    // Events
    Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index')->middleware('can:events.index');
    Route::get('/create', [EventController::class, 'create'])->name('create')->middleware('can:events.create');
    Route::post('/', [EventController::class, 'store'])->name('store')->middleware('can:events.create');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit')->middleware('can:events.edit');
    Route::put('/{id}', [EventController::class, 'update'])->name('update')->middleware('can:events.edit');
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy')->middleware('can:events.delete');
});


    // Media
    Route::prefix('media')->name('medias.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('/create', [MediaController::class, 'create'])->name('create');
        Route::post('/', [MediaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MediaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MediaController::class, 'update'])->name('update');
        Route::delete('/{id}', [MediaController::class, 'destroy'])->name('destroy');
    });

    // Organizations
    Route::get('organizations', [OrganizationController::class, 'index'])->name('organizations.index');
    Route::get('organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('organizations', [OrganizationController::class, 'store'])->name('organizations.store');
    Route::get('organizations/{id}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::put('organizations/{id}', [OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('organizations/{id}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');

    // Groups
    Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('groups/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
});

// ==================
// PROFILE ROUTES (di luar admin)
// ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
