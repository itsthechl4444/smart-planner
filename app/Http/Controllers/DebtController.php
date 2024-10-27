<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth; // Add this for authentication

class DebtController extends Controller
{
    public function index()
    {
        $debts = Auth::user()->debts()->get(); // Fetch debts associated with the logged-in user
        return view('debts.index', compact('debts'));
    }

    public function create()
    {
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        return view('debts.create', compact('currencies'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'type' => 'required|in:borrowed,lent',
            'due_date' => 'nullable|date',
            'reminder' => 'nullable|boolean',
        ]);
    
        // Create the debt entry with proper data
        $debt = Auth::user()->debts()->create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'reminder' => $request->has('reminder') ? true : false,
        ]);
    
        // Dispatch the DebtDeadlineNotification if due today and reminder is set
        $debt->sendDueDateReminder();
    
        return redirect()->route('debts.index')->with('success', 'Debt created successfully.');
    }
    

    public function show(Debt $debt)
    {
        // Authorization check
        $this->authorize('view', $debt);
        
        return view('debts.show', compact('debt'));
    }

    public function edit(Debt $debt)
    {
        // Authorization check
        $this->authorize('update', $debt);
        
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        return view('debts.edit', compact('debt', 'currencies'));
    }

    public function update(Request $request, Debt $debt)
    {
        // Authorization check
        $this->authorize('update', $debt);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'type' => 'required|in:borrowed,lent',
            'due_date' => 'nullable|date',
            'reminder' => 'nullable|boolean',
        ]);

        $debt->update($request->all());

        return redirect()->route('debts.index')->with('success', 'Debt updated successfully.');
    }

    public function destroy(Debt $debt)
    {
        // Authorization check
        $this->authorize('delete', $debt);
        
        $debt->delete();
        return redirect()->route('debts.index')->with('success', 'Debt deleted successfully.');
    }
}
