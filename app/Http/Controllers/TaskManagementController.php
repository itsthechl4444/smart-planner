<?php

// app/Http/Controllers/TaskManagementController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task; // Import the Task model
use App\Models\Label; // Import the Label model
use App\Models\Project; // Import the Project model;
use Carbon\Carbon;

class TaskManagementController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the currently authenticated user

        $projects = Auth::user()->acceptedCollaborations()->get();

        // Fetch projects the user owns
        $ownedProjects = $user->ownedProjects()->with('tasks')->get();

        // Retrieve projects the user is collaborating on with 'accepted' status
        $collaboratedProjects = $user->acceptedCollaborations()->latest()->get();

        // Merge both collections
        $projects = $ownedProjects->merge($collaboratedProjects);

        // Fetch tasks associated with the user
        $tasks = Task::where('user_id', $user->id)->with('label')->get();

        // Fetch labels associated with the user
        $labels = Label::where('user_id', $user->id)->get();

        // Calculate the number of tasks completed today
        $todayCompletedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // Determine if the user has just completed 5 tasks today
        // This logic assumes that the completion of tasks is handled elsewhere
        // and that this page is reloaded after task completions
        $showRewardModal = ($todayCompletedTasks >= 5);

        return view('taskmanagement.index', [
            'tasks' => $tasks,
            'labels' => $labels,
            'projects' => $projects, // Pass the merged projects
            'showRewardModal' => $showRewardModal, // Pass the flag to the view
        ]);
    }
}
