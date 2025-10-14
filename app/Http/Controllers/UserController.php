<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $users = User::all();
       return view('users.index', compact('users'));

    }
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate(
            [
                'name'=>'required|string|max:100',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|confirmed',
            ]
            );
            $validated['password'] = Hash::make($validated['password']);
            User::create($validated);
            return redirect()->route('user.index')->with('success','user created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $user=User::with([
        'income',
        'expense',
        'budget',
        'notification'
    ])->findOrFail($id);
    
    return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

  public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');

    }
}
