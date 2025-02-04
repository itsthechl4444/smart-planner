<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Debt;
use App\Models\Expense;
use App\Models\Saving;
use Carbon\Carbon;

class RemindersController extends Controller
{
    /**
     * Retrieve reminders based on the filter.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'month');
        $today = Carbon::today();

        switch ($filter) {
            case 'today':
                $tasks = Task::whereDate('due_date', $today)->get();
                $debts = Debt::whereDate('due_date', $today)->get();
                $expenses = Expense::whereDate('due_date', $today)->get();
                $savings = Saving::whereDate('due_date', $today)->get();
                break;

            case 'week':
                $startOfWeek = $today->copy()->startOfWeek();
                $endOfWeek = $today->copy()->endOfWeek();
                $tasks = Task::whereBetween('due_date', [$startOfWeek, $endOfWeek])->get();
                $debts = Debt::whereBetween('due_date', [$startOfWeek, $endOfWeek])->get();
                $expenses = Expense::whereBetween('due_date', [$startOfWeek, $endOfWeek])->get();
                $savings = Saving::whereBetween('due_date', [$startOfWeek, $endOfWeek])->get();
                break;

            case 'month':
            default:
                $tasks = Task::whereMonth('due_date', $today->month)
                             ->whereYear('due_date', $today->year)
                             ->get();
                $debts = Debt::whereMonth('due_date', $today->month)
                             ->whereYear('due_date', $today->year)
                             ->get();
                $expenses = Expense::whereMonth('due_date', $today->month)
                                   ->whereYear('due_date', $today->year)
                                   ->get();
                $savings = Saving::whereMonth('due_date', $today->month)
                                 ->whereYear('due_date', $today->year)
                                 ->get();
                break;
        }

        // Combine all reminders into a single collection
        $reminders = collect()
            ->merge($tasks->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'due_date' => $item->due_date,
                    'type' => 'task',
                ];
            }))
            ->merge($debts->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name, // Assuming 'name' is the field for debt name
                    'description' => $item->description,
                    'due_date' => $item->due_date,
                    'type' => 'debt',
                ];
            }))
            ->merge($expenses->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name, // Assuming 'name' is the field for expense name
                    'description' => $item->description,
                    'due_date' => $item->due_date,
                    'type' => 'expense',
                ];
            }))
            ->merge($savings->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name, // Assuming 'name' is the field for saving name
                    'description' => $item->description,
                    'due_date' => $item->due_date,
                    'type' => 'saving',
                ];
            }))
            ->sortBy('due_date') // Optional: Sort reminders by due date
            ->values();

        return response()->json($reminders);
    }
}
