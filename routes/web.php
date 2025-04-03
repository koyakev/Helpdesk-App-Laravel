<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/login', [AuthController::class, 'login_form'])->name('login_form');
Route::get('/signup', [AuthController::class, 'signup_form'])->name('signup_form');
Route::post('/login/user', [AuthController::class, 'login'])->name('login');
Route::post('/signup/user', [AuthController::class, 'signup'])->name('signup');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin_dashboard');
    
    Route::get('/users', [AdminController::class, 'users'])->name('admin_users');
    Route::post('/users/create_user', [AdminController::class, 'create_user'])->name('create_user');
    Route::put('/users/update_user/{id}', [AdminController::class, 'update_user'])->name('update_user');
    Route::delete('/users/delete_user/{id}', [AdminController::class, 'delete_user'])->name('delete_user');
    Route::put('/users/lock_user/{id}', [AdminController::class, 'lock_unlock_user'])->name('lock_unlock_user');
    
    Route::get('/departments', [AdminController::class, 'departments'])->name('admin_departments');
    Route::post('/departments/create_department', [AdminController::class, 'create_department'])->name('create_department');
    Route::put('/departments/update_department/{id}', [AdminController::class, 'update_department'])->name('update_department');
});

Route::group(['prefix' => 'user'], function() {

});