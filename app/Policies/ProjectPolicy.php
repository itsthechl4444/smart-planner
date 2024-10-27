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
     * Determine whether the user can view the project.
     */
    public function view(User $user, Project $project)
    {
        // Allow if the user is the owner or an accepted collaborator
        if ($user->id === $project->user_id) {
            return Response::allow();
        }

        if ($project->acceptedCollaborators()->where('user_id', $user->id)->exists()) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this project.');
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

        if ($hasPendingInvitation) {
            return Response::allow();
        } else {
            return Response::deny('You do not have a pending invitation to accept.');
        }
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

        if ($hasPendingInvitation) {
            return Response::allow();
        } else {
            return Response::deny('You do not have a pending invitation to decline.');
        }
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

    // ... other policy methods if needed ...
}
