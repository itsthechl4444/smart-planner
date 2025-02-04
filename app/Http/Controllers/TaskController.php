<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a list of tasks, optionally filtered.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $tasksQuery = Task::where('user_id', Auth::id());

        // Apply filter
        if ($filter === 'today') {
            $tasksQuery->whereDate('due_date', Carbon::today());
        } elseif ($filter === 'pending') {
            $tasksQuery->where('status', 'pending');
        } elseif ($filter === 'completed') {
            $tasksQuery->where('status', 'completed');
        } elseif ($filter === 'overdue') {
            // "Overdue" = status pending + past due_date
            $tasksQuery->where('status', 'pending')
                ->where('due_date', '<', Carbon::now());
        }

        $tasks = $tasksQuery->with('label')->get();
        return view('taskmanagement.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $labels = Label::where('user_id', Auth::id())->get();
        return view('tasks.create', compact('labels'));
    }

    /**
     * Store a newly created task in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|string|in:High,Medium,Low',
            'label_id'    => 'nullable|exists:labels,id',
            'notes'       => 'nullable|string',
            // Single file only
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'reminder'    => 'nullable|boolean',
        ]);

        // Assign ownership and default status
        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        // If a file is uploaded, store it and save the path
        if ($request->hasFile('attachments')) {
            $validated['attachments'] = $request->file('attachments')->store('attachments', 'public');
        }

        // Convert reminder checkbox to boolean
        $validated['reminder'] = $request->has('reminder');

        // Create the task
        $task = Task::create($validated);

        // Optional: If you have logic to send notifications when a reminder is set
        $task->sendDueDateReminder();

        return redirect()->route('taskmanagement.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display a specific task.
     */
    public function show($id)
    {
        $task = Task::with('label')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$task) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Unauthorized or not found.'], 403);
            }
            return redirect()->route('tasks.index')->with('error', 'Unauthorized or not found.');
        }

        if (request()->ajax()) {
            return response()->json($task);
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing an existing task.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }

        $labels = Label::where('user_id', Auth::id())->get();
        return view('tasks.edit', compact('task', 'labels'));
    }

    /**
     * Update an existing task in the database.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|string|in:High,Medium,Low',
            'label_id'    => 'nullable|exists:labels,id',
            'notes'       => 'nullable|string',
            // Single file only
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'reminder'    => 'nullable|boolean',
        ]);

        // If a new file is uploaded, remove old file (if any)
        if ($request->hasFile('attachments')) {
            if ($task->attachments) {
                Storage::disk('public')->delete($task->attachments);
            }
            $validated['attachments'] = $request->file('attachments')->store('attachments', 'public');
        }

        $validated['reminder'] = $request->has('reminder');
        $task->update($validated);

        return redirect()->route('taskmanagement.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a task and remove its file (if any).
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized access.');
        }

        // Delete file if it exists
        if ($task->attachments) {
            Storage::disk('public')->delete($task->attachments);
        }

        $task->delete();
        return redirect()->route('taskmanagement.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Mark a task as completed.
     */
    public function markAsCompleted($id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($task) {
            $task->status = 'completed';
            $task->save();
        }

        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    /**
     * Get statistics for tasks (completed, pending, overdue).
     */
    public function getTaskStatistics()
    {
        $userId = Auth::id();

        $completedTasks = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $pendingTasks = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $overdueTasks = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->where('due_date', '<', Carbon::now())
            ->count();

        $totalTasks = $completedTasks + $pendingTasks + $overdueTasks;

        $completedPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        $pendingPercentage   = $totalTasks > 0 ? ($pendingTasks / $totalTasks) * 100 : 0;
        $overduePercentage   = $totalTasks > 0 ? ($overdueTasks / $totalTasks) * 100 : 0;

        return response()->json([
            'completed_tasks'      => $completedTasks,
            'pending_tasks'        => $pendingTasks,
            'overdue_tasks'        => $overdueTasks,
            'completed_percentage' => $completedPercentage,
            'pending_percentage'   => $pendingPercentage,
            'overdue_percentage'   => $overduePercentage,
        ]);
    }

    /**
     * AJAX update for task status (pending/completed).
     */
    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
        }

        $request->validate([
            'completed' => 'required|boolean',
        ]);

        $task->status = $request->completed ? 'completed' : 'pending';
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task status updated successfully.']);
    }
}
