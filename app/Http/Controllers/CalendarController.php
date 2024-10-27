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
    public function index()
    {
        return view('calendar.index');
    }

    public function fetchTasks()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        $events = [];

        foreach ($tasks as $task) {
            $events[] = [
                'title' => $task->title,
                'start' => $task->due_date,
                'url' => route('tasks.show', $task->id)
            ];
        }

        return response()->json($events);
    }

    public function fetchExpenses()
    {
        $expenses = Expense::where('user_id', Auth::id())->get();
        $events = [];

        foreach ($expenses as $expense) {
            $events[] = [
                'title' => $expense->name,
                'start' => $expense->date,
                'url' => route('expenses.show', $expense->id)
            ];
        }

        return response()->json($events);
    }

    public function fetchSavings()
    {
        $savings = Saving::where('user_id', Auth::id())->get();
        $events = [];

        foreach ($savings as $saving) {
            $events[] = [
                'title' => $saving->name,
                'start' => $saving->desired_date,
                'url' => route('savings.show', $saving->id)
            ];
        }

        return response()->json($events);
    }

    public function fetchDebts()
    {
        $debts = Debt::where('user_id', Auth::id())->get();
        $events = [];

        foreach ($debts as $debt) {
            $events[] = [
                'title' => $debt->name,
                'start' => $debt->due_date,
                'url' => route('debts.show', $debt->id)
            ];
        }

        return response()->json($events);
    }
}
