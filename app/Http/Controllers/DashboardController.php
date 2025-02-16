<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Budget;
use App\Models\Saving;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        // Fetch tasks for today, this week, and this month with labels
        $tasksToday = Task::with('label')->where('user_id', $userId)
            ->whereDate('due_date', Carbon::today())
            ->get();

        $tasksThisWeek = Task::with('label')->where('user_id', $userId)
            ->whereBetween('due_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        $tasksThisMonth = Task::with('label')->where('user_id', $userId)
            ->whereMonth('due_date', Carbon::now()->month)
            ->whereYear('due_date', Carbon::now()->year)
            ->get();

        // Calculate overall totals (if needed)
        $totalIncome = Income::where('user_id', $userId)->sum('amount');
        $totalExpense = Expense::where('user_id', $userId)->sum('amount');

        // Calculate weekly totals
        $totalIncomeWeek = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('amount');

        $totalExpenseWeek = Expense::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('amount');

        // Calculate monthly totals
        $totalIncomeMonth = Income::where('user_id', $userId)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        $totalExpenseMonth = Expense::where('user_id', $userId)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        // Aggregate expenses by category for the current week
        $financeDataWeekRaw = Expense::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $financeLabelsWeek = $financeDataWeekRaw->pluck('category')->toArray();
        $financeDataWeek = $financeDataWeekRaw->pluck('total')->toArray();

        // Aggregate expenses by category for the current month
        $financeDataMonthRaw = Expense::where('user_id', $userId)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $financeLabelsMonth = $financeDataMonthRaw->pluck('category')->toArray();
        $financeDataMonth = $financeDataMonthRaw->pluck('total')->toArray();

        // Fetch budgets for this week and month
        $budgetDataWeek = Budget::where('user_id', $userId)
            ->where('period', 'week')
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        $budgetDataMonth = Budget::where('user_id', $userId)
            ->where('period', 'month')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get();

        // Fetch savings goals
        $savings = Saving::where('user_id', $userId)
            ->withSum('amounts as amount_saved', 'amount')
            ->get();

        return view('dashboard', compact(
            'tasksToday',
            'tasksThisWeek',
            'tasksThisMonth',
            'totalIncome',
            'totalExpense',
            'totalIncomeWeek',
            'totalIncomeMonth',
            'totalExpenseWeek',
            'totalExpenseMonth',
            'financeLabelsWeek',
            'financeDataWeek',
            'financeLabelsMonth',
            'financeDataMonth',
            'budgetDataWeek',
            'budgetDataMonth',
            'savings'
        ));
    }
}
