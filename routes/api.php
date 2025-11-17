<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
// -----------------------------
// Public Routes
// -----------------------------
// GET /api/notifications
Route::get('/notifications', function () {
    $user = Auth::user();
    return response()->json([
        'status' => true,
        'data' => $user->notifications // all notifications
    ]);
})->middleware('auth:sanctum');

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello API!']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// -----------------------------
// Authenticated Routes
// -----------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Users (CRUD)
    Route::apiResource('users', UserController::class);

    // Income (CRUD)
    Route::get('/income', [IncomeController::class, 'index']);
    Route::get('/income/{id}', [IncomeController::class, 'show']);
    Route::post('/income/save', [IncomeController::class, 'saveIncome']); // create or update
    Route::delete('/income/{id}', [IncomeController::class, 'destroy']);


    // Category (CRUD)
    // List
    // Category (CRUD)
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{category_id}', [CategoryController::class, 'show']);
    Route::post('/category/save', [CategoryController::class, 'saveCategory']); // create/update
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);


    // Saving (CRUD)
    // List all savings for logged-in user
    Route::get('/savings', [SavingController::class, 'index']);
    Route::get('/savings/{saving_id}', [SavingController::class, 'show']);
    Route::post('/savings/save', [SavingController::class, 'saveSaving']); // create/update
    Route::delete('/savings/{id}', [SavingController::class, 'destroy']);

    // Expenses (Merged create/update)
    // list expenses
    // List all savings for logged-in user
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::get('/expenses/{id}', [ExpenseController::class, 'show']);
    Route::post('/expenses/save', [ExpenseController::class, 'saveExpense']); // create/update
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy']); // delete expense

// Budgets (CRUD)
    // List all budgets for logged-in user

    Route::get('/budgets', [BudgetController::class, 'index']);
    Route::get('/budgets/{budget_id}', [BudgetController::class, 'show']);
    Route::post('/budgets/save', [BudgetController::class, 'saveBudget']); // create/update
    Route::delete('/budgets/{budget_id}', [BudgetController::class, 'destroy']);
});
