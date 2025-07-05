<?php

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

    Route::get('/roles',[RoleController::class, 'index'])->name('roles.index');

    Route::get('/roles/create',[RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles',[RoleController::class, 'store'])->name('roles.store');

    Route::get('/roles/{id}/edit',[RoleController::class, 'edit'])->name('roles.edit');

    Route::put('/roles/{id}',[RoleController::class, 'update'])->name('roles.update');

    Route::delete('/roles/{id}',[RoleController::class, 'destroy'])->name('roles.destroy');


    //  all users

     Route::get('/users',[UserController::class,'index'])->name('users.index');

     Route::get('/users/create',[UserController::class,'create'])->name('users.create');

     Route::post('/users',[UserController::class,'store'])->name('users.store');
});

require __DIR__.'/auth.php';
