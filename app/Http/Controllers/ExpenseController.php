<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['user', 'category'])->get();
        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('expense.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        // ✅ Create expense
        Expense::create($validated);

        // Note: Budget update happens automatically via Expense::created event

        return redirect()->route('expense.index')->with('success', 'Expense added successfully!');
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $users = User::all();
        $categories = Category::all();
        return view('expense.edit', compact('expense', 'users', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $expense->update($validated);

        // ✅ Budget will also update if you implement logic in the Expense::updated event
        // You can create a similar `updated` event in Expense.php if needed

        return redirect()->route('expense.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        // ✅ If you want, you can also subtract the amount from the Budget here
        $budget = $expense->user->budgets()
            ->where('category_id', $expense->category_id)
            ->where('month', date('F', strtotime($expense->date)))
            ->where('year', date('Y', strtotime($expense->date)))
            ->first();

        if ($budget) {
            $budget->spent_budget -= $expense->amount;
            $budget->save();
        }

        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense deleted successfully!');
    }
}
