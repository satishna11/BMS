<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    // Show all savings
    public function index()
    {
        $savings = Saving::with('user')->get(); // eager load user
        return view('saving.index', compact('savings'));
    }

    // Show form to create a new saving
    public function create()
    {
        $users = User::all(); // get all users for dropdown
        return view('saving.create', compact('users'));
    }

    // Store a new saving
    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'amount' => 'required|numeric',
            'user_id' => 'required|exists:users,user_id',
        ]);

        Saving::create($validated);

        return redirect()->route('saving.index')->with('success', 'Saving created successfully!');
    }

    // Show a single saving
    public function show($id)
    {
        $saving = Saving::with('user')->findOrFail($id);
        return view('saving.show', compact('saving'));
    }

    // Show form to edit a saving
    public function edit($id)
    {
        $saving = Saving::findOrFail($id);
        $users = User::all();
        return view('saving.edit', compact('saving', 'users'));
    }

    // Update a saving
    public function update(Request $request, $id)
    {
        $saving = Saving::findOrFail($id);

        $validated = $request->validate([
            'goal' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'amount' => 'required|numeric',
            'user_id' => 'required|exists:users,user_id',
        ]);

        $saving->update($validated);

        return redirect()->route('saving.index')->with('success', 'Saving updated successfully!');
    }

    // Delete a saving
    public function destroy($id)
    {
        $saving = Saving::findOrFail($id);
        $saving->delete();

        return redirect()->route('saving.index')->with('success', 'Saving deleted successfully!');
    }
}
