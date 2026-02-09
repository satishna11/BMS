<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * Force JSON responses for all API requests.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $request->headers->set('Accept', 'application/json');
            return $next($request);
        });
    }

    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Display a specific user.
     */
    public function show($user_id)
    {
        // Fix: Use correct relationship names
        $user = User::with(['income', 'expense', 'budget', 'notification'])->findOrFail($user_id);

        return response()->json($user);
    }

    /**
     * Update a specific user.
     */
    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,

            'password' => 'nullable|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Remove a specific user.
     */
    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
