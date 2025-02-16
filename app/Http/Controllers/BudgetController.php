<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Account;
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

    public function getBudgetData(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period');

        if (!in_array($period, ['week', 'month'])) {
            return response()->json(['error' => 'Invalid period'], 400);
        }

        $startDate = Carbon::now()->startOf($period);
        $endDate = Carbon::now()->endOf($period);

        $budgets = Budget::where('user_id', $userId)
            ->where('period', $period)
            ->select('category', 'amount')
            ->get();

        $expenses = DB::table('expenses')
            ->where('user_id', $userId)
            ->whereIn('category', $budgets->pluck('category'))
            ->whereBetween('date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as amount_spent'))
            ->groupBy('category')
            ->get();

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
        $periods = [
            'week'  => 'This Week',
            'month' => 'This Month',
        ];
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        $accounts = Account::all();
        return view('budgets.create', compact('categories', 'periods', 'currencies', 'accounts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'                  => 'required|string|max:255',
            'amount'                => 'required|numeric',
            'category'              => 'required|string|max:255',
            'date'                  => 'required|date',
            'period'                => 'required|string|in:week,month',
            'currency'              => 'required|string|max:10',
            'account_id'            => 'nullable|exists:accounts,id',
            'overspending_reminder' => 'nullable|boolean',
        ]);

        $validatedData['account_id'] = $request->filled('account_id') ? $request->account_id : null;
        $validatedData['overspending_reminder'] = $request->has('overspending_reminder');
        $validatedData['user_id'] = Auth::id();

        Budget::create($validatedData);

        return redirect(route('financemanagement.index') . '#budgets')
            ->with('success', 'Budget created successfully.');
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
        $periods = [
            'week'  => 'This Week',
            'month' => 'This Month',
        ];
        $currencies = ['PHP', 'USD', 'EUR', 'GBP', 'JPY', 'AUD', 'CAD', 'CHF', 'CNY', 'SEK', 'NZD'];
        $accounts = Account::all();
        return view('budgets.edit', compact('budget', 'categories', 'periods', 'currencies', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'                  => 'required|string|max:255',
            'amount'                => 'required|numeric',
            'category'              => 'required|string|max:255',
            'date'                  => 'required|date',
            'period'                => 'required|string|in:week,month',
            'currency'              => 'required|string|max:10',
            'account_id'            => 'nullable|exists:accounts,id',
            'overspending_reminder' => 'nullable|boolean',
        ]);

        $validatedData['account_id'] = $request->filled('account_id') ? $request->account_id : null;
        $validatedData['overspending_reminder'] = $request->has('overspending_reminder');

        $budget = Budget::findOrFail($id);
        $this->authorize('update', $budget);

        $validatedData['user_id'] = Auth::id();

        $budget->update($validatedData);

        return redirect(route('financemanagement.index') . '#budgets')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $this->authorize('delete', $budget);
        $budget->delete();

        return redirect(route('financemanagement.index') . '#budgets')
            ->with('success', 'Budget deleted successfully.');
    }
}
