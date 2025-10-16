<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    // 🔹 Show all budgets
    public function index()
    {
        $budgets = Budget::with(['user', 'category'])->get(); // eager load user & category
        return view('budget.index', compact('budgets'));
    }

    // 🔹 Show form to create a new budget
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('budget.create', compact('users', 'categories'));
    }

    // 🔹 Store a new budget
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'year' => 'required|integer',
            'month' => 'required|string',
            'planned_budget' => 'required|numeric',
            'spent_budget' => 'nullable|numeric',
            'remaining' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        Budget::create($request->all());
        return redirect()->route('budget.index')->with('success', 'Budget created successfully!');
    }

    // 🔹 Show form to edit an existing budget
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $users = User::all();
        $categories = Category::all();
        return view('budget.edit', compact('budget', 'users', 'categories'));
    }

    // 🔹 Update an existing budget
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'year' => 'required|integer',
            'month' => 'required|string',
            'planned_budget' => 'required|numeric',
            'spent_budget' => 'nullable|numeric',
            'remaining' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        $budget = Budget::findOrFail($id);
        $budget->update($request->all());

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully!');
    }

    // 🔹 Delete a budget
    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();

        return redirect()->route('budget.index')->with('success', 'Budget deleted successfully!');
    }
}
