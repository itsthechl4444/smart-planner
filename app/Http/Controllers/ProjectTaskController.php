<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProjectTaskRequest; // If using Form Requests


class ProjectTaskController extends Controller
{
    /**
     * Display the form to create a new project task.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function create(Project $project)
    {
        // Authorization: Ensure the user can create tasks for the project
        $this->authorize('create', [ProjectTask::class, $project]);

        // Fetch all labels or relevant labels associated with the project
        $labels = Label::all(); // Adjust this as per your application's logic

        return view('projecttasks.create', compact('project', 'labels'));
    }

    /**
     * Store a newly created project task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project        $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Project $project)
    {
        // Authorization: Ensure the user can create tasks for the project
        $this->authorize('create', [ProjectTask::class, $project]);

        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:Low,Medium,High',
            'label_id' => 'nullable|exists:labels,id',
            'notes' => 'nullable|string',
            'reminder' => 'nullable|boolean',
            'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'user_id' => 'nullable|exists:users,id', // Optional assigned user
        ]);

        // Handle file upload if attachments are present
        if ($request->hasFile('attachments')) {
            $path = $request->file('attachments')->store('attachments', 'public');
            $validated['attachments'] = $path;
        }

        // Create the project task
        $task = $project->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'label_id' => $validated['label_id'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'reminder' => $validated['reminder'] ?? false,
            'attachments' => $validated['attachments'] ?? null,
            'status' => 'pending', // Default status
            'user_id' => $validated['user_id'] ?? null, // Optional assigned user
        ]);

        // Redirect back to the project show page with success message
        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Task created successfully.');

    }

    /**
     * Display the specified project task.
     *
     * @param  \App\Models\Project       $project
     * @param  \App\Models\ProjectTask   $task
     * @return \Illuminate\View\View
     */
    public function show(Project $project, ProjectTask $task)
    {
        // Authorization: Ensure the user can view the task
        $this->authorize('view', $task);

        return view('projecttasks.show', compact('project', 'task'));
    }

    // Show form to edit a project task
    public function edit(Project $project, ProjectTask $task)
    {
        $labels = Label::all();
        return view('projecttasks.edit', compact('project', 'task', 'labels'));
    }

     /**
     * Update the specified project task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project        $project
     * @param  \App\Models\ProjectTask    $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project, ProjectTask $task)
    {
        // Authorization
        $this->authorize('update', $task);
    
        // Validate incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:Low,Medium,High',
            'label_id' => 'nullable|exists:labels,id',
            'notes' => 'nullable|string',
            'reminder' => 'nullable|boolean',
            'attachments' => 'nullable|file|max:10240', // Max size set to 10MB
            'user_id' => 'nullable|exists:users,id', // Optional assigned user
        ]);
    
        // Update task with validated data
        $task->update($validatedData);
    
        // Handle file upload and replacement if a new file is uploaded
        if ($request->hasFile('attachments')) {
            if ($task->attachments) {
                \Storage::disk('public')->delete($task->attachments);
            }
            $task->attachments = $request->file('attachments')->store('attachments', 'public');
            $task->save();
        }
    
        // Redirect back to the project show page with success message
        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Task updated successfully.');
    }
    



    // Delete a project task
    public function destroy(Project $project, ProjectTask $task)
    {
        // Delete the attachment file if it exists
        if ($task->attachments) {
            \Storage::disk('public')->delete($task->attachments);
        }

        // Delete the task
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Task deleted successfully.');
    }
}
