<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskReminderNotification;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all'); // Default to 'all' if no filter is provided

        // Get the authenticated user's standalone tasks
        $tasksQuery = Task::where('user_id', Auth::id());

        // Apply filter based on the query parameter
        if ($filter === 'today') {
            $tasksQuery->whereDate('due_date', Carbon::today());
        } elseif ($filter === 'pending') {
            $tasksQuery->where('status', 'pending');
        } elseif ($filter === 'completed') {
            $tasksQuery->where('status', 'completed');
        } elseif ($filter === 'overdue') {
            // Filter overdue tasks: not completed and due date is in the past
            $tasksQuery->where('status', 'pending')
                       ->where('due_date', '<', Carbon::now());
        }

        $tasks = $tasksQuery->with('label')->get(); // Retrieve the filtered tasks with labels

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $labels = Label::where('user_id', Auth::id())->get();
        return view('tasks.create', compact('labels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:High,Medium,Low',
            'label_id' => 'nullable|exists:labels,id',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'reminder' => 'nullable|boolean',
        ]);
    
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; 
    
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $request->file('attachments')->store('attachments', 'public');
        }
    
        $validated['reminder'] = $request->has('reminder') ? true : false;
    
        $task = Task::create($validated);
    
        // Dispatch notification if reminder is set and due date is today
        $task->sendDueDateReminder();
    
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }
    
    

    public function show($id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', Auth::id())
                    ->with('label')
                    ->first();

        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }

        $labels = Label::where('user_id', Auth::id())->get(); // Get labels associated with the authenticated user
        return view('tasks.edit', compact('task', 'labels'));
    }

    public function update(Request $request, Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:High,Medium,Low',
            'label_id' => 'nullable|exists:labels,id',
            'notes' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx', // Validate each file in attachments array
            'reminder' => 'nullable|boolean',
        ]);
    
        if ($request->hasFile('attachments')) {
            // Delete previous attachments if they exist
            if ($task->attachments) {
                foreach (json_decode($task->attachments) as $attachment) {
                    Storage::disk('public')->delete($attachment);
                }
            }
    
            // Store new attachments
            $newAttachments = [];
            foreach ($request->file('attachments') as $file) {
                $newAttachments[] = $file->store('attachments', 'public');
            }
            $validated['attachments'] = json_encode($newAttachments);
        }
    
        $validated['reminder'] = $request->has('reminder') ? true : false;
    
        $task->update($validated);
    
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
    
    
    
    
    public function destroy(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {

            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }

        if ($task->attachments) {
            Storage::disk('public')->delete($task->attachments);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function markAsCompleted($id)
{
    $task = Task::where('id', $id)->where('user_id', Auth::id())->first();
    
    if ($task) {
        $task->status = 'completed'; // Update the status to 'completed'
        $task->save(); // Save the changes to the database
    }

    return redirect()->back()->with('success', 'Task marked as completed.');
}


public function getTaskStatistics()
{
    $userId = Auth::id(); // Get the authenticated user ID

    // Count completed tasks
    $completedTasks = Task::where('user_id', $userId)
        ->where('status', 'completed')
        ->count();

    // Count pending tasks (e.g., tasks that are not completed and are due today or later)
    $pendingTasks = Task::where('user_id', $userId)
        ->where('status', 'pending')
        ->count();

    // Count overdue tasks (tasks that are pending but past due date)
    $overdueTasks = Task::where('user_id', $userId)
        ->where('status', 'pending')
        ->where('due_date', '<', Carbon::now())
        ->count();

    // Total tasks for calculating percentages
    $totalTasks = $completedTasks + $pendingTasks + $overdueTasks;

    // Calculate percentages for each status (ensure no division by zero)
    $completedPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
    $pendingPercentage = $totalTasks > 0 ? ($pendingTasks / $totalTasks) * 100 : 0;
    $overduePercentage = $totalTasks > 0 ? ($overdueTasks / $totalTasks) * 100 : 0;

    // Return the data to the frontend (in JSON format)
    return response()->json([
        'completed_tasks' => $completedTasks,
        'pending_tasks' => $pendingTasks,
        'overdue_tasks' => $overdueTasks,
        'completed_percentage' => $completedPercentage,
        'pending_percentage' => $pendingPercentage,
        'overdue_percentage' => $overduePercentage,
    ]);
}



}
