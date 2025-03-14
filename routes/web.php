<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneralDataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('/business')->group(function () {
    Route::get('/', [BusinessController::class, 'index'])->name('business.index');
    Route::post('/store', [BusinessController::class, 'store'])->name('business.store');
    Route::get('/all', [BusinessController::class, 'all'])->name('business.all');
});

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
});


Route::prefix('/general')->group(function () {
    Route::get('/all-countries', [GeneralDataController::class, 'allCountries'])->name('countries.all');
    Route::get('/all-currencies', [GeneralDataController::class, 'allCurrencies'])->name('currencies.all');
});
