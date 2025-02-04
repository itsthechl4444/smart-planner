<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectTaskController extends Controller
{
    /**
     * Display a listing of the tasks for a project.
     */
    public function index(Project $project)
    {
        // Authorization: owner or accepted collaborator can view tasks
        $this->authorize('viewAny', [ProjectTask::class, $project]);

        // Load tasks with their labels and assigned users
        $tasks = $project->tasks()->with(['label', 'assignedUser'])->get();

        return view('projecttasks.index', compact('project', 'tasks'));
    }

    /**
     * Show the form for creating a new project task.
     */
    public function create(Project $project)
    {
        // Authorization: owner or accepted collaborator can create tasks
        $this->authorize('create', [ProjectTask::class, $project]);

        return view('projecttasks.create', compact('project'));
    }

    /**
     * Store a newly created project task in storage.
     */
    public function store(Request $request, Project $project)
    {
        // Authorization
        $this->authorize('create', [ProjectTask::class, $project]);

        // Validate
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date|after_or_equal:today',
            'priority'    => 'required|in:Low,Medium,High',
            'notes'       => 'nullable|string',
            'reminder'    => 'nullable|boolean',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Handle file upload if attachments are present
        if ($request->hasFile('attachments')) {
            $path = $request->file('attachments')->store('attachments', 'public');
            $validated['attachments'] = $path;
        }

        // Create the task
        $task = $project->tasks()->create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date'    => $validated['due_date'],
            'priority'    => $validated['priority'],
            'notes'       => $validated['notes'] ?? null,
            'reminder'    => $validated['reminder'] ?? false,
            'attachments' => $validated['attachments'] ?? null,
            'status'      => 'pending',
            'user_id'     => Auth::id(),  // The user who created the task
        ]);

        // Send notification if reminder is set and due date is today
        $task->sendDueDateReminder();

        Log::info("ProjectTaskController: Task ID {$task->id} created in project ID {$project->id} by user ID " . Auth::id() . ".");

        // Redirect to project show page (or tasks index) after creation
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified project task.
     */
    public function show(Project $project, ProjectTask $task)
    {
        // Authorization: owner or accepted collaborator can view
        $this->authorize('view', $task);

        return view('projecttasks.show', compact('project', 'task'));
    }

    /**
     * Show the form to edit a project task.
     */
    public function edit(Project $project, ProjectTask $task)
    {
        // Authorization: owner or accepted collaborator can edit
        $this->authorize('update', $task);

        return view('projecttasks.edit', compact('project', 'task'));
    }

    /**
     * Update the specified project task in storage.
     */
    public function update(Request $request, Project $project, ProjectTask $task)
    {
        // Authorization
        $this->authorize('update', $task);

        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date|after_or_equal:today',
            'priority'    => 'nullable|in:Low,Medium,High',
            'notes'       => 'nullable|string',
            'reminder'    => 'nullable|boolean',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        // Replace existing file if a new one is uploaded
        if ($request->hasFile('attachments')) {
            if ($task->attachments) {
                Storage::disk('public')->delete($task->attachments);
            }
            $validatedData['attachments'] = $request->file('attachments')->store('attachments', 'public');
        }

        // Perform the update
        $task->update([
            'title'       => $validatedData['title'],
            'description' => $validatedData['description'] ?? $task->description,
            'due_date'    => $validatedData['due_date'] ?? $task->due_date,
            'priority'    => $validatedData['priority'] ?? $task->priority,
            'notes'       => $validatedData['notes'] ?? $task->notes,
            'reminder'    => $validatedData['reminder'] ?? $task->reminder,
            'attachments' => $validatedData['attachments'] ?? $task->attachments,
        ]);

        // Reminders
        $task->sendDueDateReminder();

        Log::info("ProjectTaskController: Task ID {$task->id} updated in project ID {$project->id} by user ID " . Auth::id() . ".");

        // Redirect to project show page (or tasks index) after update
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a project task.
     */
    public function destroy(Project $project, ProjectTask $task)
    {
        // Authorization: owner or accepted collaborator can delete
        $this->authorize('delete', $task);

        try {
            if ($task->attachments) {
                Storage::disk('public')->delete($task->attachments);
            }

            $task->delete();

            Log::info("ProjectTaskController: Task ID {$task->id} deleted in project ID {$project->id} by user ID " . Auth::id() . ".");

            // **IMPORTANT**: Redirect to the project show page with success message
            return redirect()->route('projects.show', $project->id)
                ->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            Log::error("ProjectTaskController: Failed to delete Task ID {$task->id}. Error: {$e->getMessage()}");

            return redirect()->back()->with('error', 'Failed to delete the task.');
        }
    }

    /**
     * Update the status of a project task via AJAX.
     */
    public function updateStatus(Request $request, Project $project, ProjectTask $task)
    {
        // Authorization: ensure the user can update
        $this->authorize('update', $task);

        $validated = $request->validate([
            'status' => 'required|in:completed,pending',
        ]);

        try {
            $task->status = $validated['status'];
            $task->save();

            Log::info("ProjectTaskController: Task ID {$task->id} status updated to '{$task->status}' by user ID " . Auth::id() . ".");

            // Return JSON if done via AJAX
            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error("ProjectTaskController: Failed to update status. Error: {$e->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => 'Failed to update task status.',
            ], 500);
        }
    }

    /**
     * Mark the project task as completed via a standard POST request.
     */
    public function markAsCompleted(Project $project, ProjectTask $task)
    {
        $this->authorize('update', $task);

        $task->status = 'completed';
        $task->save();

        return redirect()->back()->with('success', 'Task marked as completed.');
    }
}
