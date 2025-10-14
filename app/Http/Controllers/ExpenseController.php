<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // Show all expenses
    public function index()
    {
        // Eager load relationships to avoid N+1 queries
        $expenses = Expense::with(['user', 'category'])->get();

        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        // Return a form to add new expense
        return view('expense.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:category,category_id',
            'amount' => 'required|numeric',
            'date' => 'required|date'
        ]);

        Expense::create($validated);

        return redirect()->route('expense.index')->with('success', 'Expense added successfully!');
    }

    public function show($id)
    {
        $expense = Expense::with(['user', 'category'])->findOrFail($id);
        return view('expense.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expense.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:category,category_id',
            'amount' => 'required|numeric',
            'date' => 'required|date'
        ]);

        $expense->update($validated);

        return redirect()->route('expense.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully!');
    }
}
