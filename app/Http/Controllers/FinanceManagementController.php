<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Debt;
use App\Models\Budget;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceManagementController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Get the ID of the currently authenticated user

        // Fetching all entries associated with the logged-in user
        $accounts = Account::where('user_id', $userId)->get();
        $expenses = Expense::where('user_id', $userId)->get();
        $incomes = Income::where('user_id', $userId)->get();
        $debts = Debt::where('user_id', $userId)->get();
        $budgets = Budget::where('user_id', $userId)->get();
        $savings = Saving::where('user_id', $userId)->get();
        // Define or fetch currencies
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];
        $paymentMethods = ['Cash', 'Card', 'ATM', 'Online'];
        $periods = [
            'week' => 'This Week',
            'month' => 'This Month',
        ];

        // Returning the view with the fetched data
        return view('financemanagement.index', compact('accounts', 'expenses', 'incomes', 'debts', 'budgets', 'savings', 'currencies', 'categories', 'paymentMethods', 'periods'));
    }
}
