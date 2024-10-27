<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Auth::user()->incomes; // Fetch incomes for the logged-in user
        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'source_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Auth::user()->incomes()->create($request->all());

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function show(Income $income)
    {
        $this->authorize('view', $income); // Add authorization check
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $this->authorize('update', $income); // Add authorization check
        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        $this->authorize('update', $income); // Add authorization check

        $request->validate([
            'source_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $income->update($request->all());

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        $this->authorize('delete', $income); // Add authorization check
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
