<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Expense;
use App\Models\Saving;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display the calendar view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * Fetch tasks and format them for FullCalendar.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTasks(Request $request)
    {
        $filter = $request->query('filter', 'month'); // Default filter
        $userId = Auth::id();

        // Define date ranges based on the filter
        switch ($filter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate   = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate   = now()->endOfWeek();
                break;
            case 'month':
            default:
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
                break;
        }

        try {
            $tasks = Task::where('user_id', $userId)
                ->whereBetween('due_date', [$startDate, $endDate])
                ->get();

            $events = [];

            foreach ($tasks as $task) {
                // Skip tasks without a due date
                if (!$task->due_date) {
                    continue;
                }

                // Format the due date as 'YYYY-MM-DD'
                $dueDate = $task->due_date->toDateString();

                $events[] = [
                    'title'          => $task->title,
                    'start'          => $dueDate,
                    'type'           => 'task',
                    'url'            => route('tasks.show', $task->id),
                    'extendedProps'  => [
                        'description' => $task->description,
                    ],
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            \Log::error('Error fetching tasks: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch tasks.'], 500);
        }
    }

    /**
     * Fetch debts and format them for FullCalendar.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchDebts(Request $request)
    {
        $filter = $request->query('filter', 'month'); // Default filter
        $userId = Auth::id();

        // Define date ranges based on the filter
        switch ($filter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate   = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate   = now()->endOfWeek();
                break;
            case 'month':
            default:
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
                break;
        }

        try {
            $debts = Debt::where('user_id', $userId)
                ->whereBetween('due_date', [$startDate, $endDate])
                ->get();

            $events = [];

            foreach ($debts as $debt) {
                // Skip debts without a due date
                if (!$debt->due_date) {
                    continue;
                }

                // Format the due date as 'YYYY-MM-DD'
                $dueDate = $debt->due_date->toDateString();

                $events[] = [
                    'title'          => $debt->name,
                    'start'          => $dueDate,
                    'type'           => 'debt',
                    'url'            => route('debts.show', $debt->id),
                    'extendedProps'  => [
                        'description' => $debt->description,
                    ],
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            \Log::error('Error fetching debts: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch debts.'], 500);
        }
    }

    /**
     * Fetch expenses and format them for FullCalendar.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchExpenses(Request $request)
    {
        $filter = $request->query('filter', 'month'); // Default filter
        $userId = Auth::id();

        // Define date ranges based on the filter
        switch ($filter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate   = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate   = now()->endOfWeek();
                break;
            case 'month':
            default:
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
                break;
        }

        try {
            $expenses = Expense::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();

            $events = [];

            foreach ($expenses as $expense) {
                if (!$expense->date) {
                    continue; // Skip expenses without a date
                }

                $date = $expense->date->toDateString();

                $events[] = [
                    'title'          => $expense->name,
                    'start'          => $date,
                    'type'           => 'expense',
                    'url'            => route('expenses.show', $expense->id),
                    'extendedProps'  => [
                        'description' => $expense->description,
                    ],
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            \Log::error('Error fetching expenses: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch expenses.'], 500);
        }
    }

    /**
     * Fetch savings and format them for FullCalendar.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchSavings(Request $request)
    {
        $filter = $request->query('filter', 'month'); // Default filter
        $userId = Auth::id();

        // Define date ranges based on the filter
        switch ($filter) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate   = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate   = now()->endOfWeek();
                break;
            case 'month':
            default:
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
                break;
        }

        try {
            $savings = Saving::where('user_id', $userId)
                ->whereNotNull('desired_date')
                ->whereBetween('desired_date', [$startDate, $endDate])
                ->get();

            $events = [];

            foreach ($savings as $saving) {
                if (!$saving->desired_date) {
                    continue; // Skip savings without a desired date
                }

                $desiredDate = $saving->desired_date->toDateString();

                $events[] = [
                    'title'          => $saving->name,
                    'start'          => $desiredDate,
                    'type'           => 'saving',
                    'url'            => route('savings.show', $saving->id),
                    'extendedProps'  => [
                        'description' => $saving->description,
                    ],
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            \Log::error('Error fetching savings: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch savings.'], 500);
        }
    }

    public function showDay($date)
    {
        $userId = Auth::id();
    
        try {
            $events = [
                'tasks' => Task::where('user_id', $userId)
                    ->whereDate('due_date', $date)
                    ->get(),
                'debts' => Debt::where('user_id', $userId)
                    ->whereDate('due_date', $date)
                    ->get(),
                'expenses' => Expense::where('user_id', $userId)
                    ->whereDate('date', $date)
                    ->get(),
                'savings' => Saving::where('user_id', $userId)
                    ->whereDate('desired_date', $date)
                    ->get(),
            ];
    
            return view('calendar.day', compact('events', 'date'));
        } catch (\Exception $e) {
            \Log::error('Error fetching events for day: ' . $e->getMessage());
            return redirect()->route('calendar.index')->with('error', 'Failed to fetch events for the selected day.');
        }
    }
    

}
