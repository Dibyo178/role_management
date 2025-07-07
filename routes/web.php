<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('backend.pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// route start

Route::get('test',function(){

    return view('backend.pages.auth.login');

});

Route::middleware(['auth', 'verified'])->group(function(){

    Route::get('user-logout',[UserController::class,'logout'])->name('user-logout');

    Route::get('/roles',[RoleController::class, 'index'])->middleware('permission:role-menu|role-list')->name('roles.index');

    Route::get('/roles/create',[RoleController::class, 'create'])->middleware('permission:role-create')->name('roles.create');
    Route::post('/roles',[RoleController::class, 'store'])->middleware('permission:role-create')->name('roles.store');

    Route::get('/roles/{id}/edit',[RoleController::class, 'edit'])->middleware('permission:role-edit')->name('roles.edit');

    Route::put('/roles/{id}',[RoleController::class, 'update'])->middleware('permission:role-edit')->name('roles.update');

    Route::delete('/roles/{id}',[RoleController::class, 'destroy'])->middleware('permission:role-delete')->name('roles.destroy');


    //  all users

     Route::get('/users',[UserController::class,'index'])->middleware('permission:user-menu|user-list')->name('users.index');

     Route::get('/users/create',[UserController::class,'create'])->middleware('permission:user-create')->name('users.create');

     Route::post('/users',[UserController::class,'store'])->middleware('permission:user-create')->name('users.store');

     Route::get('/users/{id}/edit',[UserController::class,'edit'])->middleware('permission:user-edit')->name('users.edit');

     Route::put('/users/{id}',[UserController::class,'update'])->middleware('permission:user-edit')->name('users.update');

     Route::delete('/users/{id}',[UserController::class,'destroy'])->middleware('permission:user-delete')->name('users.destroy');

    //  Product All routes

    Route::get('/products',[ProductController::class,'index'])->middleware('permission:product-menu|product-list')->name('product.index');

    Route::get('/products/create',[ProductController::class,'create'])->middleware('permission:product-create')->name('product.create');

    Route::post('/products',[ProductController::class,'store'])->middleware('permission:product-create')->name('products.store');

    Route::get('/products/{id}/edit',[ProductController::class,'edit'])->middleware('permission:product-edit')->name('products.edit');

    Route::put('/products/{id}',[ProductController::class,'update'])->middleware('permission:product-edit')->name('products.update');

    Route::delete('/products/{id}',[ProductController::class,'destroy'])->middleware('permission:product-delete')->name('products.destroy');


});

require __DIR__.'/auth.php';
