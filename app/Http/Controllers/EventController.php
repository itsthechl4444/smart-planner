<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Savings;
use App\Models\Debt;
use App\Models\Expense;

class EventController extends Controller
{
    public function getEvents()
{
    $tasks = Task::all();
    $savings = Savings::all();
    $debts = Debt::all();
    $expenses = Expense::all();

    $events = [];

    foreach ($tasks as $task) {
        $events[] = [
            'title' => $task->title,
            'start' => $task->due_date,
            'color' => '#007bff'
        ];
    }

    foreach ($savings as $saving) {
        $events[] = [
            'title' => 'Savings: ' . $saving->amount,
            'start' => $saving->desired_date,
            'color' => '#28a745'
        ];
    }

    foreach ($debts as $debt) {
        $events[] = [
            'title' => 'Debt: ' . $debt->amount,
            'start' => $debt->date,
            'color' => '#dc3545'
        ];
    }

    foreach ($expenses as $expense) {
        $events[] = [
            'title' => 'Expense: ' . $expense->amount,
            'start' => $expense->date,
            'color' => '#ffc107'
        ];
    }

    return response()->json($events);
}

}
