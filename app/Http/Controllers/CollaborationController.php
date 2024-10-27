<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProjectInvitationNotification;
use App\Notifications\ProjectInvitationResponseNotification;
use App\Notifications\CollaboratorRemovedNotification;
use Illuminate\Support\Facades\Log;

class CollaborationController extends Controller
{
    /**
     * Send an invitation to collaborate on a project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(Request $request, Project $project)
    {
        // Authorization: Only the project owner can invite collaborators
        $this->authorize('invite', $project);

        // Validate the request
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->input('email');

        // Find the user by email
        $user = User::where('email', $email)->first();

        // Check if the user is already a collaborator or has a pending invitation
        $existing = $project->collaborators()->where('user_id', $user->id)->first();

        if ($existing) {
            return redirect()->route('projects.show', $project)->with('error', 'User is already a collaborator or has a pending invitation.');
        }

        // Check if the maximum number of collaborators has been reached (3)
        $currentCollaborators = $project->acceptedCollaborators()->count();
        if ($currentCollaborators >= 3) {
            return redirect()->route('projects.show', $project)->with('error', 'Maximum number of collaborators reached.');
        }

        // Attach the user with 'pending' status
        $project->collaborators()->attach($user->id, ['status' => 'pending']);

        // Send an in-app and email notification to the user
        $user->notify(new ProjectInvitationNotification($project, Auth::user()));

        return redirect()->route('projects.show', $project)->with('success', 'Invitation sent successfully.');
    }

    /**
     * Accept a collaboration invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptInvitation(Request $request, Project $project)
    {
        $user = Auth::user();

        // Log the attempt
        Log::info('User attempting to accept invitation', ['user_id' => $user->id, 'project_id' => $project->id]);

        // Authorization: Ensure the user can accept the invitation
        $this->authorize('acceptInvitation', $project);

        // Check if the user has a pending invitation
        $pivotRecord = $project->pendingCollaborators()->where('user_id', $user->id)->first();

        if (!$pivotRecord) {
            Log::warning('No pending invitation found', ['user_id' => $user->id, 'project_id' => $project->id]);
            return redirect()->route('notifications.index')->with('error', 'No pending invitation found for this project.');
        }

        // Check if maximum collaborators reached
        if ($project->acceptedCollaborators()->count() >= 3) {
            return redirect()->route('notifications.index')->with('error', 'Cannot accept invitation. Maximum collaborators reached.');
        }

        // Update the pivot record to 'accepted'
        $project->collaborators()->updateExistingPivot($user->id, ['status' => 'accepted']);

        // Notify the owner about acceptance
        $project->owner->notify(new ProjectInvitationResponseNotification($project, $user, 'accepted'));

        // Mark the corresponding notification as read
        $notification = $user->notifications()
                             ->where('type', 'App\Notifications\ProjectInvitationNotification')
                             ->where('data->project_id', $project->id)
                             ->first();
        if ($notification) {
            $notification->markAsRead();
            Log::info('Notification marked as read', ['user_id' => $user->id, 'notification_id' => $notification->id]);
        }

        return redirect()->route('projects.show', $project)->with('success', 'You have successfully joined the project.');
    }

    /**
     * Decline a collaboration invitation.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function declineInvitation(Project $project)
    {
        $user = Auth::user();

        // Authorization: Ensure the user can decline the invitation
        $this->authorize('declineInvitation', $project);

        // Check if the user has a pending invitation
        $pivotRecord = $project->pendingCollaborators()->where('user_id', $user->id)->first();

        if (!$pivotRecord) {
            return redirect()->route('notifications.index')->with('error', 'No pending invitation found for this project.');
        }

        // Update the pivot record to 'declined'
        $project->collaborators()->updateExistingPivot($user->id, ['status' => 'declined']);

        // Notify the owner about declination
        $project->owner->notify(new ProjectInvitationResponseNotification($project, $user, 'declined'));

        // Mark the corresponding notification as read
        $notification = $user->notifications()
                             ->where('type', 'App\Notifications\ProjectInvitationNotification')
                             ->where('data->project_id', $project->id)
                             ->first();
        if ($notification) {
            $notification->markAsRead();
            Log::info('Notification marked as read', ['user_id' => $user->id, 'notification_id' => $notification->id]);
        }

        return redirect()->route('projects.index')->with('success', 'You have declined the project invitation.');
    }

    /**
     * Remove a collaborator from the project.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $collaborator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Project $project, User $collaborator)
    {
        // Authorization: Only the project owner can remove collaborators
        $this->authorize('removeCollaborator', $project);

        // Prevent owner from being removed
        if ($collaborator->id === $project->owner->id) {
            return redirect()->route('projects.show', $project)->with('error', 'Cannot remove the project owner.');
        }

        // Check if the user is a collaborator
        if (!$project->acceptedCollaborators()->where('user_id', $collaborator->id)->exists()) {
            return redirect()->route('projects.show', $project)->with('error', 'User is not an accepted collaborator.');
        }

        // Detach the collaborator
        $detached = $project->collaborators()->detach($collaborator->id);

        // Check if detach was successful
        if ($detached) {
            // Notify the removed collaborator
            $collaborator->notify(new CollaboratorRemovedNotification($project, Auth::user()));

            return redirect()->route('projects.show', $project)->with('success', 'Collaborator removed successfully.');
        } else {
            return redirect()->route('projects.show', $project)->with('error', 'Failed to remove collaborator. Please try again.');
        }
    }
}
