<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create tasks for the project.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Project  $project
     * @return bool
     */
    public function create(User $user, Project $project)
    {
        // Allow if the user is the owner of the project
        if ($user->id === $project->user_id) {
            return true;
        }

        // Allow if the user is an accepted collaborator
        if ($user->acceptedCollaborations()->where('project_id', $project->id)->exists()) {
            return true;
        }

        // Deny otherwise
        return false;
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\ProjectTask $task
     * @return bool
     */
    public function update(User $user, ProjectTask $task)
    {
        return $this->create($user, $task->project);
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\ProjectTask $task
     * @return bool
     */
    public function delete(User $user, ProjectTask $task)
    {
        return $this->create($user, $task->project);
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\ProjectTask $task
     * @return bool
     */
    public function view(User $user, ProjectTask $task)
    {
        return $this->create($user, $task->project);
    }

    // ... other policy methods as needed ...
}
