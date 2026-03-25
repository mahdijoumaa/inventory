<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
/*
Route::get('/', function () {
    return view('index')->middleware(['auth', 'verified']);
});
*/
Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/supplier', SupplierController::class,['names'=> 'supplier']);
});

require __DIR__.'/auth.php';
