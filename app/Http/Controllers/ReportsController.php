<?php


namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Expense;
use App\Models\Budget;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF; // Import PDF facade

class ReportsController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        // Calculate completed tasks
        $completedCount = Task::where('user_id', $userId)
            ->where('status', 'completed') // Adjust the status name as per your DB
            ->count();

        // Calculate pending tasks
        $pendingCount = Task::where('user_id', $userId)
            ->where('status', 'pending') // Adjust the status name as per your DB
            ->count();

        // Calculate overdue tasks
        $overdueCount = Task::where('user_id', $userId)
            ->where('due_date', '<', now()) // Tasks with due dates in the past
            ->where('status', '!=', 'completed') // Exclude completed tasks
            ->count();

        // Pass counts to the view
        return view('reports.index', compact('completedCount', 'pendingCount', 'overdueCount'));
    }

    public function getTaskReports(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period', 'week');
        $today = Carbon::now();
        $startDate = null;

        // Determine the date range based on the period
        switch ($period) {
            case 'week':
                $startDate = $today->startOfWeek();
                break;
            case 'month':
                $startDate = $today->startOfMonth();
                break;
            default:
                $startDate = $today->startOfWeek(); // Default to 'week' if period is unrecognized
                break;
        }


        // Fetch tasks
        $tasks = Task::where('user_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->with('label') // Ensure the 'label' relationship is defined
            ->get();

        // Group tasks by label name
        $taskDistribution = $tasks->groupBy(function ($task) {
            return $task->label ? $task->label->name : 'No Label';
        })->map(function ($group) {
            return $group->count();
        });

        // Prepare labels and counts
        $labels = $taskDistribution->keys()->toArray();
        $taskCounts = $taskDistribution->values()->toArray();

        // Return data as JSON
        return response()->json([
            'completed' => Task::where('user_id', $userId)->where('status', 'completed')->count(),
            'pending' => Task::where('user_id', $userId)->where('status', 'pending')->count(),
            'overdue' => Task::where('user_id', $userId)->where('due_date', '<', now())->where('status', '!=', 'completed')->count(),
            'labels' => $labels,
            'taskCounts' => $taskCounts,
        ]);
    }


    /**
     * Fetch expense summary based on the selected period.
     */
    public function getExpenseReports(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period', 'week'); // Default to 'week'
        $today = Carbon::now();
        $startDate = null;

        // Define predefined categories
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];

        // Determine the date range based on the period
        switch ($period) {
            case 'week':
                $startDate = $today->copy()->startOfWeek();
                break;
            case 'month':
                $startDate = $today->copy()->startOfMonth();
                break;
            default:
                $startDate = $today->copy()->startOfWeek();
                break;
        }

        // Fetch budgets for user in the specified period
        $budgets = Budget::where('user_id', $userId)
            ->where('period', $period)
            ->whereIn('category', $categories)
            ->get()
            ->keyBy('category'); // Key by category for easy access

        // Fetch expenses for user in the specified period
        $expenses = Expense::where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->whereIn('category', $categories)
            ->get();

        // Group expenses by category and sum amounts
        $expenseGroup = $expenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        });

        // Prepare expense summary
        $expenseSummary = [];
        $totalBudget = 0;
        $totalSpent = 0;

        // Iterate through each category to prepare the expense summary
        foreach ($categories as $category) {
            // Fetch allocated budget for the category, if it exists
            $allocated = $budgets->has($category) ? $budgets[$category]->amount : 0;

            // Fetch total spent for the category
            $spent = $expenseGroup->get($category, 0);

            // Calculate percentage of budget spent; avoid division by zero
            $percentage = $allocated > 0 ? round(($spent / $allocated) * 100, 2) : 0.00;

            // Debugging: Log the values for each category
            Log::info("Category: {$category}, Allocated Budget: {$allocated}, Amount Spent: {$spent}, Percentage: {$percentage}");

            // Add the category data to the expense summary array
            $expenseSummary[] = [
                'category' => $category,
                'allocated_budget' => $allocated,
                'amount_spent' => $spent,
                'percentage_of_budget' => $percentage,
            ];

            // Update total budget and total spent for overall calculations
            $totalBudget += $allocated;
            $totalSpent += $spent;
        }

        // Handle Unbudgeted expenses
        $unbudgetedExpenses = Expense::where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->whereNotIn('category', $categories)
            ->sum('amount');

        if ($unbudgetedExpenses > 0) {
            // Calculate percentage of unbudgeted expenses relative to the total budget
            $percentage = $totalBudget > 0 ? round(($unbudgetedExpenses / $totalBudget) * 100, 2) : 0.00;

            $expenseSummary[] = [
                'category' => 'Unbudgeted',
                'allocated_budget' => 0, // No specific allocated budget for unbudgeted expenses
                'amount_spent' => $unbudgetedExpenses,
                'percentage_of_budget' => $percentage,
            ];

            $totalSpent += $unbudgetedExpenses;
        }

        // Debugging: Log the final total budget and total spent
        Log::info("Total Budget: {$totalBudget}, Total Spent: {$totalSpent}");

        // Return JSON response
        return response()->json([
            'expenseSummary' => $expenseSummary,
            'totalBudget' => $totalBudget,
            'totalSpent' => $totalSpent,
        ]);
    }


    public function getIncomeReports(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period', 'week'); // Default to 'week'
        $today = Carbon::now();

        // Determine the date range based on the period
        switch ($period) {
            case 'week':
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
                break;
            default:
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
        }

        // Fetch income records for the user in the specified period
        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Group incomes by source_name and sum amounts
        $incomeGroup = $incomes->groupBy('source_name')->map(function ($group) {
            return $group->sum('amount');
        });

        // Prepare income summary
        $incomeSummary = [];
        $totalIncome = 0;

        foreach ($incomeGroup as $sourceName => $amountReceived) {
            $incomeSummary[] = [
                'source_name' => $sourceName,
                'amount_received' => $amountReceived,
            ];
            $totalIncome += $amountReceived;
        }

        // Return JSON response
        return response()->json([
            'incomeSummary' => $incomeSummary,
            'totalIncome' => $totalIncome,
        ]);
    }


    /**
     * Fetch budget progress data based on the selected period.
     */
    public function getBudgetProgressReports(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period', 'week'); // Default to 'week'
        $today = Carbon::now();

        // Determine the date range based on the period
        switch ($period) {
            case 'week':
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
                break;
            default:
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
        }

        // Fetch budgets for user in the specified period
        $budgets = Budget::where('user_id', $userId)
            ->where('period', $period)
            ->get()
            ->keyBy('category'); // Key by category for easy access

        // Fetch expenses for user in the specified period
        $expenses = Expense::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Group expenses by category and sum amounts
        $expenseGroup = $expenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        });

        // Prepare budget progress data
        $budgetProgress = [];
        foreach ($budgets as $category => $budget) {
            $allocatedBudget = $budget->amount;
            $amountSpent = $expenseGroup->get($category, 0);
            $remainingBudget = $allocatedBudget - $amountSpent;

            // Ensure remaining budget is not negative
            $remainingBudget = max($remainingBudget, 0);

            $budgetProgress[] = [
                'category' => $category,
                'allocated_budget' => $allocatedBudget,
                'amount_spent' => $amountSpent,
                'remaining_budget' => $remainingBudget,
            ];
        }

        // Return JSON response
        return response()->json([
            'budgetProgress' => $budgetProgress,
        ]);
    }

    /**
     * Download the reports as a PDF.
     */
    public function downloadPDF(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period', 'week');
        $today = Carbon::now();
        $startDate = null;
        $endDate = null;

        // Determine the date range based on the period
        switch ($period) {
            case 'week':
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
                break;
            default:
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
        }

        // Fetch data for the PDF

        // Task Summary
        $completedCount = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pendingCount = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $overdueCount = Task::where('user_id', $userId)
            ->where('due_date', '<', now())
            ->where('status', '!=', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Task Distribution
        $tasks = Task::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('label')
            ->get();

        $taskDistribution = $tasks->groupBy(function ($task) {
            return $task->label ? $task->label->name : 'No Label';
        })->map(function ($group) {
            return $group->count();
        });

        $taskLabels = $taskDistribution->keys()->toArray();
        $taskCounts = $taskDistribution->values()->toArray();

        // Expense Summary
        $expenseData = $this->calculateExpenseSummary($userId, $period, $startDate);
        // Income Overview
        $incomeData = $this->calculateIncomeOverview($userId, $startDate, $endDate);
        // Budget Progress
        $budgetData = $this->calculateBudgetProgress($userId, $period, $startDate, $endDate);

        // Prepare data for PDF
        $data = array_merge([
            'period' => ucfirst($period),
            'date' => $today->format('F d, Y'),
            'completedCount' => $completedCount,
            'pendingCount' => $pendingCount,
            'overdueCount' => $overdueCount,
            'taskLabels' => $taskLabels,
            'taskCounts' => $taskCounts,
        ], $expenseData, $incomeData, $budgetData);

        // Generate PDF
        $pdf = PDF::loadView('reports.pdf', $data);

        // Return the PDF for download
        return $pdf->download('reports_' . $period . '_' . $today->format('Ymd') . '.pdf');
    }

    // Helper methods to calculate expense summary, income overview, and budget progress
    private function calculateExpenseSummary($userId, $period, $startDate)
    {
        $categories = ['Food', 'Transportation', 'Utilities', 'Entertainment', 'Healthcare'];

        // Fetch budgets
        $budgets = Budget::where('user_id', $userId)
            ->where('period', $period)
            ->whereIn('category', $categories)
            ->get()
            ->keyBy('category');

        // Fetch expenses
        $expenses = Expense::where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->whereIn('category', $categories)
            ->get();

        // Group and calculate
        $expenseGroup = $expenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        });

        // Prepare summary
        $expenseSummary = [];
        $totalBudget = 0;
        $totalSpent = 0;

        foreach ($categories as $category) {
            $allocated = $budgets->has($category) ? $budgets[$category]->amount : 0;
            $spent = $expenseGroup->get($category, 0);
            $percentage = $allocated > 0 ? round(($spent / $allocated) * 100, 2) : 0.00;

            $expenseSummary[] = [
                'category' => $category,
                'allocated_budget' => $allocated,
                'amount_spent' => $spent,
                'percentage_of_budget' => $percentage,
            ];

            $totalBudget += $allocated;
            $totalSpent += $spent;
        }

        // Unbudgeted expenses
        $unbudgetedExpenses = Expense::where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->whereNotIn('category', $categories)
            ->sum('amount');

        if ($unbudgetedExpenses > 0) {
            $percentage = $totalBudget > 0 ? round(($unbudgetedExpenses / $totalBudget) * 100, 2) : 0.00;

            $expenseSummary[] = [
                'category' => 'Unbudgeted',
                'allocated_budget' => 0,
                'amount_spent' => $unbudgetedExpenses,
                'percentage_of_budget' => $percentage,
            ];

            $totalSpent += $unbudgetedExpenses;
        }

        return [
            'expenseSummary' => $expenseSummary,
            'totalBudget' => $totalBudget,
            'totalSpent' => $totalSpent,
        ];
    }

    private function calculateIncomeOverview($userId, $startDate, $endDate)
    {
        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $incomeGroup = $incomes->groupBy('source_name')->map(function ($group) {
            return $group->sum('amount');
        });

        $incomeSummary = [];
        $totalIncome = 0;

        foreach ($incomeGroup as $sourceName => $amountReceived) {
            $incomeSummary[] = [
                'source_name' => $sourceName,
                'amount_received' => $amountReceived,
            ];
            $totalIncome += $amountReceived;
        }

        return [
            'incomeSummary' => $incomeSummary,
            'totalIncome' => $totalIncome,
        ];
    }

    private function calculateBudgetProgress($userId, $period, $startDate, $endDate)
    {
        $budgets = Budget::where('user_id', $userId)
            ->where('period', $period)
            ->get()
            ->keyBy('category');

        $expenses = Expense::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $expenseGroup = $expenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        });

        $budgetProgress = [];
        foreach ($budgets as $category => $budget) {
            $allocatedBudget = $budget->amount;
            $amountSpent = $expenseGroup->get($category, 0);
            $remainingBudget = $allocatedBudget - $amountSpent;

            $budgetProgress[] = [
                'category' => $category,
                'allocated_budget' => $allocatedBudget,
                'amount_spent' => $amountSpent,
                'remaining_budget' => $remainingBudget,
            ];
        }

        return [
            'budgetProgress' => $budgetProgress,
        ];
    }
}
