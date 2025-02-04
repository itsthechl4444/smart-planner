<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a given project.
     */
    public function view(User $user, Project $project)
    {
        // Owner or accepted collaborator
        if ($user->id === $project->user_id) {
            return Response::allow();
        }

        if ($project->acceptedCollaborators()->where('user_id', $user->id)->exists()) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this project.');
    }

    /**
     * Determine whether the user can update (edit) the project.
     */
    public function update(User $user, Project $project)
    {
        // Only the owner can update
        return $user->id === $project->user_id
            ? Response::allow()
            : Response::deny('Only the project owner can update this project.');
    }

    /**
     * Determine whether the user can delete the project.
     */
    public function delete(User $user, Project $project)
    {
        // Only the owner can delete
        return $user->id === $project->user_id
            ? Response::allow()
            : Response::deny('Only the project owner can delete this project.');
    }

    /**
     * Determine whether the user can send invitations.
     */
    public function invite(User $user, Project $project)
    {
        return $user->id === $project->user_id
            ? Response::allow()
            : Response::deny('Only the project owner can invite collaborators.');
    }

    /**
     * Determine whether the user can accept invitations.
     */
    public function acceptInvitation(User $user, Project $project)
    {
        $hasPendingInvitation = $project->collaborators()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'pending')
            ->exists();

        return $hasPendingInvitation
            ? Response::allow()
            : Response::deny('You do not have a pending invitation to accept.');
    }

    /**
     * Determine whether the user can decline invitations.
     */
    public function declineInvitation(User $user, Project $project)
    {
        $hasPendingInvitation = $project->collaborators()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'pending')
            ->exists();

        return $hasPendingInvitation
            ? Response::allow()
            : Response::deny('You do not have a pending invitation to decline.');
    }

    /**
     * Determine whether the user can remove collaborators.
     */
    public function removeCollaborator(User $user, Project $project)
    {
        return $user->id === $project->user_id
            ? Response::allow()
            : Response::deny('Only the project owner can remove collaborators.');
    }
}
