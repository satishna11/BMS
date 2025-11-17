<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
class BudgetController extends Controller
{
    // Require authentication
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/budgets - Get all budgets for logged-in user
    public function index()
    {
        $budgets = Budget::with('category')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'status' => true,
            'data' => $budgets
        ]);
    }

    // POST /api/budgets/save - Create or update a budget

public function saveBudget(Request $request)
{
    $validated = $request->validate([
        'budget_id'   => 'nullable|integer',
        'category_id' => 'required|exists:categories,category_id',
        'month'       => 'required|string',
        'year'        => 'required|digits:4',
        'planned_budget' => 'required|numeric|min:0',
    ]);

    $userId = Auth::id();

    // Convert month name to number (1-12)
    $monthNumber = date('m', strtotime($validated['month'] . ' 1'));

    // Calculate spent_budget from expenses
    $spent = Expense::where('user_id', $userId)
        ->where('category_id', $validated['category_id'])
        ->whereMonth('date', $monthNumber)
        ->whereYear('date', $validated['year'])
        ->sum('amount');

    $remaining = $validated['planned_budget'] - $spent;

    // Only two valid values for ENUM
    $status = $remaining >= 0 ? 'On Track' : 'Overspent';

    // CREATE
    if (!isset($validated['budget_id']) || $validated['budget_id'] == 0) {
        $budget = Budget::create([
            'user_id'       => $userId,
            'category_id'   => $validated['category_id'],
            'month'         => $validated['month'],
            'year'          => $validated['year'],
            'planned_budget'=> $validated['planned_budget'],
            'spent_budget'  => $spent,
            'remaining'     => $remaining,
            'status'        => $status,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Budget created successfully!',
            'data'    => $budget
        ], 201); // ✅ 201 CREATED
    }

    // UPDATE
    $budget = Budget::where('budget_id', $validated['budget_id'])
        ->where('user_id', $userId)
        ->first();

    if (!$budget) {
        return response()->json([
            'status'  => false,
            'message' => 'Budget not found or not yours'
        ], 404);
    }

    $budget->update([
        'category_id'   => $validated['category_id'],
        'month'         => $validated['month'],
        'year'          => $validated['year'],
        'planned_budget'=> $validated['planned_budget'],
        'spent_budget'  => $spent,
        'remaining'     => $remaining,
        'status'        => $status,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Budget updated successfully!',
        'data'    => $budget
    ], 200);
}





    // GET /api/budgets/{id} - Get single budget of logged-in user
    public function show($id)
    {
        $budget = Budget::with('category')
            ->where('budget_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$budget) {
            return response()->json([
                'status' => false,
                'message' => 'Budget not found or not yours'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $budget
        ]);
    }

    // DELETE /api/budgets/{id} - Delete a budget
    public function destroy($id)
    {
        $budget = Budget::where('budget_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$budget) {
            return response()->json([
                'status' => false,
                'message' => 'Budget not found or not yours'
            ], 404);
        }

        $budget->delete();

        return response()->json([
            'status' => true,
            'message' => 'Budget deleted successfully'
        ]);
    }
}
