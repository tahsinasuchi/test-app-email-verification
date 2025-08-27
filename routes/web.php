<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\CustomerAdminController;
use App\Http\Controllers\FrontAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Verified;
use App\Models\Customer;
use App\Models\Admin;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// 言語切替ルート
Route::get('locale/{locale}', function ($locale) {
    // 言語コードが許可されているか確認
    if (in_array($locale, ['ja', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back(); // 元のページにリダイレクト
})->name('locale.switch');

// -------- FRONT (Members) --------
Route::get('/login', [FrontAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [FrontAuthController::class, 'login'])->name('front.login.post');
Route::post('/logout', [FrontAuthController::class, 'logout'])->name('front.logout');

Route::get('/entry', [FrontAuthController::class, 'showEntry'])->name('front.entry');
Route::post('/entry', [FrontAuthController::class, 'entry'])->name('front.entry.post');

// email verification (member)
Route::get('/email/verify', function () {
    return view('front.auth.verify-notice');
})->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect()->route('login')->with('status','Email Verified. You can login now.');
// })->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = Customer::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified(); 
    }

    return redirect()->route('login')->with('status', 'Email Verified. You can login now.');
})->middleware(['signed'])->name('verification.verify');

Route::get('/admin/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = Admin::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified(); 
    }

    return redirect()->route('admin.login')->with('status', 'Email Verified. You can login now.');
})->middleware(['signed'])->name('admin.verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// mypage (ensure verified via middleware in controllers if desired)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/edit', [FrontAuthController::class, 'mypageEdit'])->name('front.mypage.edit');
    Route::post('/mypage/edit', [FrontAuthController::class, 'mypageUpdate'])->name('front.mypage.update');
});

// -------- ADMIN --------
Route::prefix('admin')->group(function () {
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register.post');

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // admin email verify screen (needs separate guard auth)
    Route::get('/email/verify', function () {
        return view('admin.auth.verify-notice');
    })->middleware('auth:admin')->name('admin.verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $user = auth('admin')->user();
        $user->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    })->middleware(['auth:admin','throttle:6,1'])->name('admin.verification.send');

    // Protected admin area
    Route::middleware('auth:admin')->group(function () {
        // Admin members CRUD
        Route::get('/member', [AdminMemberController::class, 'index'])->name('admin.members.index');
        Route::get('/member/new', [AdminMemberController::class, 'create'])->name('admin.members.create');
        Route::post('/member/new', [AdminMemberController::class, 'store'])->name('admin.members.store');
        Route::get('/member/{id}/edit', [AdminMemberController::class, 'edit'])->name('admin.members.edit');
        Route::put('/member/{id}/edit', [AdminMemberController::class, 'update'])->name('admin.members.update');
        Route::get('/member/export/csv', [AdminMemberController::class, 'exportCsv'])->name('admin.members.csv');
        Route::delete('/member/{id}', [AdminMemberController::class, 'destroy'])->name('admin.members.destroy');

        // Customers CRUD for admins
        Route::get('/customer', [CustomerAdminController::class, 'index'])->name('admin.customers.index');
        Route::get('/customer/new', [CustomerAdminController::class, 'create'])->name('admin.customers.create');
        Route::post('/customer/new', [CustomerAdminController::class, 'store'])->name('admin.customers.store');
        Route::get('/customer/{id}/edit', [CustomerAdminController::class, 'edit'])->name('admin.customers.edit');
        Route::put('/customer/{id}/edit', [CustomerAdminController::class, 'update'])->name('admin.customers.update');
        Route::get('/customer/export/csv', [CustomerAdminController::class, 'exportCsv'])->name('admin.customers.csv');
        Route::delete('/customers/{id}', [CustomerAdminController::class, 'destroy'])->name('admin.customers.destroy');
    });
});
