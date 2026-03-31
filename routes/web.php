<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UnitController;
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

    //Route:Supplier
    Route::resource('/supplier', SupplierController::class,['names'=> 'supplier']);
    //Route:Customer
    Route::resource('/customer', CustomerController::class,['names'=> 'customer']);

    //Route:category
    Route::resource('categories', CategoryController::class,['names'=> 'categories']);

        //Route:Product
    Route::resource('products', ProductController::class,['names'=> 'products']);
            //Route:unit
    Route::resource('unit', UnitController::class,['names'=> 'unit']);

              //Route:Purchase
    Route::resource('purchase', PurchaseController::class,['names'=> 'purchase']);


    
});

require __DIR__.'/auth.php';
