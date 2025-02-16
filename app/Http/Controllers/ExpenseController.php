<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        // Fetch expenses associated with the logged-in user
        $expenses = Auth::user()->expenses;
        return view('financemanagement.index', compact('expenses'));
    }

    public function create()
    {
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];
        $paymentMethods = ['Cash', 'Card', 'ATM', 'Online'];
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];

        return view('expenses.create', compact('categories', 'paymentMethods', 'currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'amount'         => 'required|numeric',
            'category'       => 'required|string',
            'date'           => 'required|date',
            'currency'       => 'required|string',
            'payment_method' => 'required|string',
            'notes'          => 'nullable|string',
            'attachment'     => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip|max:5120', // 5MB limit
        ]);

        $expense = new Expense($request->all());
        $expense->user_id = Auth::id();

        if ($request->hasFile('attachment')) {
            $expense->attachment = $request->file('attachment')->store('attachments', 'public');
        }

        $expense->save();

        // Redirect to Finance Management page with '#expenses' hash to open the Expenses tab
        return redirect(route('financemanagement.index') . '#expenses')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];
        $paymentMethods = ['Cash', 'Card', 'ATM', 'Online'];
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];

        return view('expenses.edit', compact('expense', 'categories', 'paymentMethods', 'currencies'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'amount'           => 'required|numeric',
            'category'         => 'required|string',
            'date'             => 'required|date',
            'currency'         => 'required|string',
            'payment_method'   => 'required|string',
            'notes'            => 'nullable|string',
            'attachment'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip|max:5120', // 5MB limit
            'remove_attachment' => 'nullable|boolean',
        ]);

        // Update expense details (except attachment fields)
        $expense->fill($request->except(['attachment', 'remove_attachment']));

        // Remove current attachment if requested
        if ($request->has('remove_attachment') && $request->remove_attachment) {
            if ($expense->attachment) {
                Storage::disk('public')->delete($expense->attachment);
                $expense->attachment = null;
            }
        }

        // Handle new attachment upload if provided
        if ($request->hasFile('attachment')) {
            if ($expense->attachment) {
                Storage::disk('public')->delete($expense->attachment);
            }
            $expense->attachment = $request->file('attachment')->store('attachments', 'public');
        }

        $expense->save();

        // Redirect to Finance Management page with '#expenses' hash to ensure the Expenses section is active
        return redirect(route('financemanagement.index') . '#expenses')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);

        if ($expense->attachment) {
            Storage::disk('public')->delete($expense->attachment);
        }

        $expense->delete();

        return redirect(route('financemanagement.index') . '#expenses')
            ->with('success', 'Expense deleted successfully.');
    }
}
