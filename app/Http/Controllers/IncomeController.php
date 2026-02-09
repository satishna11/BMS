<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Routing\Controller;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Require authentication
    }

    // GET /api/income - list all incomes for logged-in user
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => true,
            'data' => $incomes
        ], 200);
    }

    // POST /api/income/save - create or update income
    public function saveIncome(Request $request)
{
    $validated = $request->validate([
        'id' => 'nullable|integer',
        'source' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
    ]);

    $userId = Auth::id();

    // CREATE
    if (!isset($validated['id']) || $validated['id'] == 0) {
        $income = Income::create([
            'user_id' => $userId,
            'source' => $validated['source'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Income created successfully!',
            'data' => $income
        ], 201);
    }

    // UPDATE
    $income = Income::where('income_id', $validated['id'])
        ->where('user_id', $userId)
        ->first();

    if (!$income) {
        return response()->json([
            'status' => false,
            'message' => 'Income not found or not yours'
        ], 404);
    }

    $income->update([
        'source' => $validated['source'],
        'amount' => $validated['amount'],
        'date' => $validated['date'],
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Income updated successfully!',
        'data' => $income
    ], 200);
}
    // GET /api/income/{id} - get a single income
    public function show($id)
    {
        $income = Income::where('income_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$income) {
            return response()->json([
                'status' => false,
                'message' => 'Income not found or not yours'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $income
        ], 200);
    }

    // DELETE /api/income/{id} - delete income
    public function destroy($id)
    {
        $income = Income::where('income_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$income) {
            return response()->json([
                'status' => false,
                'message' => 'Income not found or not yours'
            ], 404);
        }

        $income->delete();

        return response()->json([
            'status' => true,
            'message' => 'Income deleted successfully!'
        ], 200);
    }
}
