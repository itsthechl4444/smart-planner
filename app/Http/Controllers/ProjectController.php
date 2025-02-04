<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CollaborationInvitation;
use App\Notifications\ProjectInvitationResponseNotification;

class ProjectController extends Controller
{
    /**
     * Enforce authentication on all methods.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $user = Auth::user();

        // Retrieve projects owned by the user
        $ownedProjects = $user->ownedProjects()->latest()->get();

        // Retrieve projects the user is collaborating on with 'accepted' status
        $collaboratedProjects = $user->acceptedCollaborations()->latest()->get();

        // Combine both collections
        $projects = $ownedProjects->merge($collaboratedProjects);

        // Fetch tasks associated with the user (if needed)
        $tasks = Task::where('user_id', $user->id)->with('label')->get();

        // Fetch labels associated with the user (if needed)
        $labels = Label::where('user_id', $user->id)->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        // Define the authenticated user
        $user = Auth::user();

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Create the project associated with the authenticated user as the owner
        $project = $user->ownedProjects()->create($validated);

        // Redirect to the Task Management page with the "projects" tab active
        return redirect()->route('taskmanagement.index')
            ->with('activeTab', 'projects')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Authorization: Ensure the user can view the project
        $this->authorize('view', $project);

        // Load related tasks and accepted collaborators
        $project->load(['tasks', 'acceptedCollaborators', 'owner']);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        // Authorization: Ensure the user can update the project
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Authorization: Ensure the user can update the project
        $this->authorize('update', $project);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Update the project
        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Authorization: Ensure the user can delete the project
        $this->authorize('delete', $project);

        $project->delete();

        // Redirect to the Task Management index after deletion
        return redirect()->route('taskmanagement.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Display the members of the specified project.
     */
    public function members(Project $project)
    {
        // Authorization: Ensure the user can view the project's members
        $this->authorize('view', $project);

        // Eager load relationships
        $project->load(['owner', 'acceptedCollaborators', 'pendingCollaborators']);

        return view('projects.members', compact('project'));
    }
}
