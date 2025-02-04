<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Budget;
use App\Models\Account;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::all();
        return view('financemanagement.index', compact('budgets'));
    }

    // BudgetController.php
    public function getBudgetData(Request $request)
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        $period = $request->query('period');

        if (!in_array($period, ['week', 'month'])) {
            return response()->json(['error' => 'Invalid period'], 400);
        }

        // Determine the start and end dates based on the period
        $startDate = Carbon::now()->startOf($period);
        $endDate = Carbon::now()->endOf($period);

        // Fetch budgets for the user based on the selected period
        $budgets = Budget::where('user_id', $userId)
            ->where('period', $period)
            ->select('category', 'amount')
            ->get();

        // Fetch expenses for the user in the same period
        $expenses = Expense::where('user_id', $userId)
            ->whereIn('category', $budgets->pluck('category')) // Fetch expenses that have categories in the budgets
            ->whereBetween('date', [$startDate, $endDate]) // Filter expenses within the selected period
            ->select('category', DB::raw('SUM(amount) as amount_spent'))
            ->groupBy('category')
            ->get();

        // Combine budgets and expenses
        $expenseData = $budgets->map(function ($budget) use ($expenses) {
            $expense = $expenses->firstWhere('category', $budget->category);
            $amountSpent = $expense ? $expense->amount_spent : 0;
            $percentageSpent = $budget->amount > 0 ? round(($amountSpent / $budget->amount) * 100, 2) : 0;

            return [
                'category' => $budget->category,
                'allocated_budget' => $budget->amount,
                'amount_spent' => $amountSpent,
                'percentage_of_budget' => $percentageSpent,
            ];
        });

        return response()->json([
            'budgets' => $expenseData,
        ]);
    }


    public function create()
    {
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];
        // Define periods with both value and label
        $periods = [
            'week' => 'This Week',
            'month' => 'This Month',
        ];
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        $accounts = Account::all();
        return view('budgets.create', compact('categories', 'periods', 'currencies', 'accounts'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'period' => 'required|string|in:week,month',
            'currency' => 'required|string|max:10',
            'account_id' => 'nullable|exists:accounts,id',
            'overspending_reminder' => 'nullable|boolean',
        ]);

        $validatedData['overspending_reminder'] = $request->has('overspending_reminder');
        $validatedData['user_id'] = Auth::id(); // Assign authenticated user ID

        Budget::create($validatedData);

        return redirect()->route('financemanagement.index')->with('success', 'Budget created successfully.');
    }


    public function show($id)
    {
        $budget = Budget::findOrFail($id);
        return view('budgets.show', compact('budget'));
    }

    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];
        // Define periods with both value and label
        $periods = [
            'week' => 'This Week',
            'month' => 'This Month',
        ];
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        $accounts = Account::all();
        return view('budgets.edit', compact('budget', 'categories', 'periods', 'currencies', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'period' => 'required|string|in:week,month',
            'currency' => 'required|string|max:10',
            'account_id' => 'nullable|exists:accounts,id',
            'overspending_reminder' => 'nullable|boolean',
        ]);

        $validatedData['overspending_reminder'] = $request->has('overspending_reminder');

        $budget = Budget::findOrFail($id);

        $this->authorize('update', $budget);

        $validatedData['user_id'] = Auth::id(); // Assign authenticated user ID

        $budget->update($validatedData);

        return redirect()->route('financemanagement.index')->with('success', 'Budget updated successfully.');
    }


    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);

        $this->authorize('delete', $budget);

        $budget->delete();
        return redirect()->route('financemanagement.index')->with('success', 'Budget deleted successfully.');
    }
}
