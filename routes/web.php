<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\Admin\AdminLeaveController;
use App\Exports\UsersLeaveExport;
use App\Exports\UserLeaveHistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

// Ana sayfa rotası
Route::get('/', function () {
    return view('welcome');
});

// Dashboard rotası, sadece doğrulanmış kullanıcılar erişebilir
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin rotaları, sadece 'role' alanı 1 olan kullanıcılar erişebilir
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class)->except(['show']);

    // Admin için yıllık izin yönetimi
    Route::get('/leaves', [AdminLeaveController::class, 'index'])->name('leaves');
    Route::post('/leave/request/{requestId}', [AdminLeaveController::class, 'updateLeaveRequest'])->name('leave.request.update');
    Route::post('/annual-leave/update/{user}', [AdminLeaveController::class, 'updateAnnualLeave'])->name('annual.leave.update');
    Route::get('/leave/history/{userId}', [AdminLeaveController::class, 'showUserLeaveHistory'])->name('leave.history');
    Route::get('/leaves/{user}/edit', [AdminLeaveController::class, 'edit'])->name('leaves.edit');

    // Excel indirme rotası
    Route::get('/leaves/export', function () {
        return Excel::download(new UsersLeaveExport, 'yillik_izinler.xlsx');
    })->name('leaves.export');

    // Kullanıcının izin geçmişini Excel olarak indir
    Route::get('/leaves/{user}/history/export', function ($user) {
        $user = User::findOrFail($user);
        $fileName = 'izin_gecmisi_' . str_replace(' ', '_', $user->first_name . '_' . $user->last_name) . '.xlsx';
        return Excel::download(new UserLeaveHistoryExport($user), $fileName);
    })->name('leave.history.export');
});

// Kullanıcı izin yönetimi rotaları
Route::middleware(['auth'])->group(function () {
    Route::get('/leave/requests', [LeaveController::class, 'showLeaveRequests'])->name('leave.requests');
    Route::post('/leave/request', [LeaveController::class, 'requestLeave'])->name('leave.request');
});

// Authentication rotalarını dahil et
require __DIR__.'/auth.php';

