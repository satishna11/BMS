<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SavingController;


Route::get('/', function () {
    return view('welcome');
});


Route::resource('users', UserController::class);
Route::resource('income', IncomeController::class);
Route::resource('category', CategoryController::class);
Route::resource('expense', ExpenseController::class);
Route::resource('saving', SavingController::class);
