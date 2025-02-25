<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Frontend\PageController;



Route::get('/', [PageController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::resource('rentals', RentalController::class);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/cars', CarController::class);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
