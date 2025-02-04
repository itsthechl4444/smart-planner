<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Auth::user()->accounts; // Fetch accounts associated with the logged-in user
        return view('financemanagement.index', compact('accounts'));
    }

    public function create()
    {
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        return view('accounts.create', compact('currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'balance' => 'required|numeric',
            'currency' => 'required|string|max:3',
        ]);

        Auth::user()->accounts()->create($request->all()); // Associate the account with the logged-in user
        return redirect()->route('financemanagement.index')->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        // Ensure the account belongs to the logged-in user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        // Ensure the account belongs to the logged-in user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        return view('accounts.edit', compact('account', 'currencies'));
    }

    public function update(Request $request, Account $account)
    {
        // Ensure the account belongs to the logged-in user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'balance' => 'required|numeric',
            'currency' => 'required|string|max:3',
        ]);

        $account->update($request->all());
        return redirect()->route('financemanagement.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        // Ensure the account belongs to the logged-in user
        if ($account->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $account->delete();
        return redirect()->route('financemanagement.index')->with('success', 'Account deleted successfully.');
    }
}
