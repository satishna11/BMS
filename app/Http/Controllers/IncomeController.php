<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\delete;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes=Income::all();
        return view('income.index',compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('income.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate(
            [
                'source'=>'rewuired|string|max:255',
                'amount'=>'required|numeric|min:0',
                'date'=>'required|date',
             ]
            );
            $validated['user_id']=Auth::id();
            Income::create($validated);
            return redirect()->route('income.index')->with('success','income added successfullly');

    }

    public function show(string $id)
    {
        $income=Income::with('user')->findOrFail($id);
        return view('income.show',compact('income'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $incomes=Income::findOrfail($id);
        return view('income.edit',compact('incomes'));
    }
    public function update(Request $request, string $id)
    {
        $income=Income::findOrfail($id);
         $validated=$request->validate(
            [
                'source'=>'required|string|max:255',
                'amount'=>'required|numeric|min:0',
                'date'=>'required|date',
             ]
            );
            $income->update($income);
            return redirect()->route('income.index')->with('success','income updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $income=Income::findOrfail($id);
        $income->delete();
        return redirect()->route('income.index')->with('success', 'Income deleted successfully!');

    }
}
