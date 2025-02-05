<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\generatePDF;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TrashController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('init');
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('init', [AppController::class, 'init'])->name('init');
Route::post('init', [AppController::class, 'storeAdmin'])->name('init.post');
Route::get('/generate-pdf', [generatePDF::class, 'generate']);
Route::middleware(['auth'])->group(function () {
    Route::permanentRedirect('/', 'l');
    Route::get('l', [AppController::class, 'index'])->name('l.list');
    Route::post('l/add', [AppController::class, 'store'])->name('l.new');
    Route::put('l/{id}', [AppController::class, 'update'])->name('l.update');
    Route::get('l/create', [AppController::class, 'createLocation'])->name('l.create');
    Route::post('l/store', [AppController::class, 'storeLocation'])->name('l.store');
    Route::prefix('l/{location}')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.home');
        Route::post('account/{id}/generate-statement', [AccountController::class, 'generateStatement'])->name('account.generateStatement');
        Route::resource('account', AccountController::class);
        Route::post('account/restore/{account}', [AccountController::class, 'restore'])->name('account.restore');
        Route::resource('entries', EntryController::class);
        Route::delete('delete-entries', [EntryController::class, 'destroy'])->name('entries.delete');
        Route::resource('transfers', TransferController::class);
        Route::post('entries/reconcile', [EntryController::class, 'reconcile'])->name('entries.reconcile');
        Route::get('trash', [TrashController::class, 'index'])->name('trash.list');
    });
    Route::post('l/{location}/clone', [AccountController::class, 'cloneAccounts'])->name('l.clone');
    Route::post('logout', function (Request $request) {
        $request->session()->flush();
        $request->session()->regenerate();
        Auth::logout();
    })->name('logout');
});
