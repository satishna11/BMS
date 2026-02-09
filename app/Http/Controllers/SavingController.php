<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Routing\Controller;

class SavingController extends Controller
{
    // Require authentication for all actions
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/savings - Get all savings for logged-in user
    public function index()
    {
        $savings = Saving::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => true,
            'data' => $savings
        ]);
    }

    // POST /api/savings - Create or update saving
    public function saveSaving(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'goal' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
        ]);

        $userId = Auth::id();

        // CREATE
        if (!$request->id || $request->id == 0) {
            $saving = Saving::create([
                'user_id' => $userId,
                'goal' => $request->goal,
                'target_amount' => $request->target_amount,
                'amount' => $request->amount,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Saving created successfully',
                'data' => $saving
            ], 201);
        }

        // UPDATE
        $saving = Saving::where('saving_id', $request->id)
            ->where('user_id', $userId)
            ->first();

        if (!$saving) {
            return response()->json([
                'status' => false,
                'message' => 'Saving not found or not yours'
            ], 404);
        }

        $saving->update([
            'goal' => $request->goal,
            'target_amount' => $request->target_amount,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Saving updated successfully',
            'data' => $saving
        ]);
    }

    // GET /api/savings/{id} - Get a single saving of logged-in user
    public function show($id)
    {
        $saving = Saving::where('saving_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$saving) {
            return response()->json([
                'status' => false,
                'message' => 'Saving not found or not yours'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $saving
        ]);
    }

    // DELETE /api/savings/{id} - Delete a saving
    public function destroy($id)
    {
        $saving = Saving::where('saving_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$saving) {
            return response()->json([
                'status' => false,
                'message' => 'Saving not found or not yours'
            ], 404);
        }

        $saving->delete();

        return response()->json([
            'status' => true,
            'message' => 'Saving deleted successfully'
        ]);
    }
}
