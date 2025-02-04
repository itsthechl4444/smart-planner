<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Ensure DB facade is imported
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


        // Calculate total income
        $totalIncome = Income::where('user_id', $userId)->sum('amount');

        // Calculate total expenses
        $totalExpense = Expense::where('user_id', $userId)->sum('amount');

        // Aggregate expenses by category for the current week
        $financeDataWeekRaw = Expense::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        // Transform to labels and data
        $financeLabelsWeek = $financeDataWeekRaw->pluck('category')->toArray();
        $financeDataWeek = $financeDataWeekRaw->pluck('total')->toArray();

        // Aggregate expenses by category for the current month
        $financeDataMonthRaw = Expense::where('user_id', $userId)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        // Transform to labels and data
        $financeLabelsMonth = $financeDataMonthRaw->pluck('category')->toArray();
        $financeDataMonth = $financeDataMonthRaw->pluck('total')->toArray();

        // Fetch budgets with their expenses for the current week
        $budgetDataWeek = Budget::where('user_id', $userId)
            ->where('period', 'week')
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        // Fetch budgets with their expenses for the current month
        $budgetDataMonth = Budget::where('user_id', $userId)
            ->where('period', 'month')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get();



        // Fetch savings goals along with the saved amount
        $savings = Saving::where('user_id', $userId)
            ->withSum('amounts as amount_saved', 'amount')
            ->get();

        return view('dashboard', compact(
            'tasksToday',
            'tasksThisWeek',
            'tasksThisMonth',
            'totalIncome',
            'totalExpense',
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
