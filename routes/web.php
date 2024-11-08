<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountLocationController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->group(function () {
    Route::permanentRedirect('/', 'l');
    Route::get('l', [AppController::class, 'index'])->name('l.list');
    Route::get('l/create', [AppController::class, 'createLocation'])->name('l.create');
    Route::post('l/store', [AppController::class, 'storeLocation'])->name('l.store');
    Route::prefix('l/{location}')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.home');
        Route::resource('account', AccountController::class);
        Route::resource('entries', EntryController::class);
        Route::resource('transfers', TransferController::class);
    });
    Route::post('l/{location}/clone', [AccountController::class, 'cloneAccounts'])->name('l.clone');
    Route::post('logout', function (Request $request) {
        $request->session()->flush();
        $request->session()->regenerate();
        Auth::logout();
    })->name('logout');
});
