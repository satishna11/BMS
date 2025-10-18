<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    // Show all budgets
    public function index()
    {
        $budgets = Budget::with(['user', 'category'])->get();
        return view('budget.index', compact('budgets'));
    }

    // Show form to create new budget
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('budget.create', compact('users', 'categories'));
    }

    // Store a new budget
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'planned_budget' => 'required|numeric|min:0',
            'spent_budget' => 'nullable|numeric|min:0', // optional, usually 0 at start
        ]);

        Budget::create($validated);
        // ✅ Remaining and status calculated automatically in Budget model

        return redirect()->route('budget.index')->with('success', 'Budget created successfully!');
    }

    // Show form to edit a budget
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $users = User::all();
        $categories = Category::all();
        return view('budget.edit', compact('budget', 'users', 'categories'));
    }

    // Update a budget
    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'planned_budget' => 'required|numeric|min:0',
            'spent_budget' => 'nullable|numeric|min:0',
        ]);

        $budget->update($validated);
        // ✅ Remaining and status recalculated automatically

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully!');
    }

    // Delete a budget
    public function destroy($id)
    {
        Budget::findOrFail($id)->delete();
        return redirect()->route('budget.index')->with('success', 'Budget deleted successfully!');
    }
}
