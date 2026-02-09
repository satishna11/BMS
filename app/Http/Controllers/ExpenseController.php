<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Routing\Controller;
class ExpenseController extends Controller
{
    // Require authentication for all actions
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Get all expenses of logged-in user
    public function index()
    {
        $expenses = Expense::with(['category'])
            ->where('user_id', Auth::id())  // FIXED
            ->get();

        return response()->json([
            'status' => true,
            'data' => $expenses
        ]);
    }

    // Create or Update Expense
    public function saveExpense(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',

        ]);

        $userId = Auth::id(); // logged-in user ID

        // CREATE
        if (!$request->id || $request->id == 0) {

            $expense = Expense::create([
                'user_id' => $userId,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'date' => $request->date,

            ]);

            return response()->json([
                'status' => true,
                'message' => 'Expense created successfully',
                'data' => $expense
            ]);
        }

        // UPDATE
        $expense = Expense::where('expense_id', $request->id)
            ->where('user_id', $userId) // ensure logged-in user owns it
            ->first();

        if (!$expense) {
            return response()->json([
                'status' => false,
                'message' => 'Expense not found or not yours'
            ], 404);
        }

        $expense->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,

        ]);

        return response()->json([
            'status' => true,
            'message' => 'Expense updated successfully',
            'data' => $expense
        ]);
    }
     public function show($id)
    {
        $expenses = Expense::where('expense_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$expenses) {
            return response()->json([
                'status' => false,
                'message' => 'Expense not found or not yours'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $expenses
        ], 200);
    }

    // Delete expense
    public function destroy($id)
    {
        $userId = Auth::id();

        $expense = Expense::where('expense_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$expense) {
            return response()->json([
                'status' => false,
                'message' => 'Expense not found or not yours'
            ], 404);
        }

        $expense->delete();

        return response()->json([
            'status' => true,
            'message' => 'Expense deleted successfully'
        ]);
    }
}
