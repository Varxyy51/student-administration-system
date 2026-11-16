<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\LetterTypeController as AdminLetterTypeController;
use App\Http\Controllers\Student\SubmissionController as StudentSubmissionController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }

    return redirect()->route('login');
});

// Guest Routes (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Fitur Mahasiswa
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentSubmissionController::class, 'index'])->name('dashboard');
    Route::get('/submissions/create', [StudentSubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [StudentSubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{submission}', [StudentSubmissionController::class, 'show'])->name('submissions.show');

    // Profil & Password Mahasiswa
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
});

// Fitur Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminSubmissionController::class, 'index'])->name('dashboard');
    Route::get('/submissions/{submission}', [AdminSubmissionController::class, 'show'])->name('submissions.show');
    Route::patch('/submissions/{submission}/status', [AdminSubmissionController::class, 'updateStatus'])->name('submissions.update-status');

    // CRUD Master Jenis Surat
    Route::resource('letter-types', AdminLetterTypeController::class)->except(['show']);
});

// Cetak Surat Resmi (Untuk Mahasiswa pemilik surat & Admin jika sudah Approved)
Route::get('/submissions/{submission}/print', function (\App\Models\Submission $submission) {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user->role !== 'admin' && $submission->user_id !== $user->id) {
        abort(403);
    }

    if ($submission->status !== 'approved') {
        abort(403, 'Surat belum disetujui.');
    }

    $submission->load(['user.studentProfile', 'letterType', 'reviewer']);

    return view('letters.print', compact('submission'));
})->middleware('auth')->name('submissions.print');