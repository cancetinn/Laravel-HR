<?php

use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortLeaveController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Admin\AdminLeaveController;
use App\Http\Controllers\Admin\AdminShortLeaveController;
use App\Exports\UsersLeaveExport;
use App\Exports\UserLeaveHistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

// Ana sayfa rotası
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard rotası, sadece doğrulanmış kullanıcılar erişebilir
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Kullanıcı izin yönetimi ve belge rotaları
    Route::get('/leave/requests', [LeaveController::class, 'showLeaveRequests'])->name('leave.requests');
    Route::post('/leave/request', [LeaveController::class, 'requestLeave'])->name('leave.request');
    Route::put('/leave/cancel/{id}', [LeaveController::class, 'cancelLeaveRequest'])->name('leave.cancel');

    Route::get('documents', [UserDocumentController::class, 'index'])->name('documents');
    Route::get('download-document/{document}', [UserDocumentController::class, 'downloadDocument'])->name('user.download.document');

    // Saatlik ve günlük izinler için rotalar
    Route::get('short-leaves', [ShortLeaveController::class, 'index'])->name('short_leaves.index');
    Route::get('short-leaves/create', [ShortLeaveController::class, 'create'])->name('short_leaves.create');
    Route::post('short-leaves', [ShortLeaveController::class, 'store'])->name('short_leaves.store');
    Route::delete('short-leaves/{shortLeave}', [ShortLeaveController::class, 'destroy'])->name('short_leaves.destroy');

    //Masraflar
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    //PROFİL
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

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

    // Admin belge yönetimi
    Route::get('documents', [AdminDocumentController::class, 'index'])->name('documents');
    Route::get('upload-document/{user}', [AdminDocumentController::class, 'showUploadForm'])->name('upload.document.form');
    Route::post('upload-document/{user}', [AdminDocumentController::class, 'uploadDocument'])->name('upload.document');
    Route::get('download-document/{document}', [AdminDocumentController::class, 'downloadDocument'])->name('download.document');
    Route::delete('documents/{document}', [AdminDocumentController::class, 'destroy'])->name('delete.document');

    // Kısa izinlerin yönetimi
    Route::get('short-leaves', [AdminShortLeaveController::class, 'index'])->name('short_leaves.index');
    Route::get('short-leaves/{user}', [AdminShortLeaveController::class, 'show'])->name('short_leaves.show');
    Route::post('short-leaves/{id}', [AdminShortLeaveController::class, 'update'])->name('short_leaves.update');

    // Masraflar Admin
    Route::get('expenses', [ExpenseController::class, 'adminIndex'])->name('expenses.index');
    Route::get('expenses/review/{userId}', [ExpenseController::class, 'reviewUserExpenses'])->name('expenses.review');
    Route::post('/expenses/{expense}/update-status', [ExpenseController::class, 'updateStatus'])->name('expenses.updateStatus');
    Route::post('/expenses/{expense}/update-payment-status', [ExpenseController::class, 'updatePaymentStatus'])->name('expenses.updatePaymentStatus');
});

// Authentication rotalarını dahil et
require __DIR__.'/auth.php';