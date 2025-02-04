<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProjectInvitationNotification;
use App\Notifications\ProjectInvitationResponseNotification;
use App\Notifications\CollaboratorRemovedNotification;

class CollaborationController extends Controller
{
    /**
     * Send an invitation to collaborate on a project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project        $project
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
     * @param  \App\Models\Project        $project
     * @param  \App\Models\User           $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptInvitation(Request $request, Project $project, User $user)
    {
        // Verify the signature if using signed routes (optional, see below)
        // if (! $request->hasValidSignature()) {
        //     abort(403, 'Invalid or expired invitation link.');
        // }

        $authUser = Auth::user();

        // Ensure the authenticated user matches the user in the invitation
        if ($authUser->id !== $user->id) {
            return redirect()->route('projects.index')->with('error', 'Unauthorized action.');
        }

        // Check if there is a pending invitation
        $invitation = $project->collaborators()->where('user_id', $authUser->id)->wherePivot('status', 'pending')->first();

        if (!$invitation) {
            return redirect()->route('projects.index')->with('error', 'No pending invitation found.');
        }

        // Update the invitation status to 'accepted'
        $project->collaborators()->updateExistingPivot($authUser->id, ['status' => 'accepted']);

        // Notify the project owner
        $inviter = $project->owner;
        $inviter->notify(new ProjectInvitationResponseNotification($project, $authUser, 'accepted'));

        // Redirect to the project page with a success message and trigger welcome modal
        return redirect()->route('projects.show', $project->id)->with(['success' => 'You have accepted the invitation.', 'show_welcome_modal' => true]);
    }

    /**
     * Decline a collaboration invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project        $project
     * @param  \App\Models\User           $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function declineInvitation(Request $request, Project $project, User $user)
    {
        // Verify the signature if using signed routes (optional, see below)
        // if (! $request->hasValidSignature()) {
        //     abort(403, 'Invalid or expired invitation link.');
        // }

        $authUser = Auth::user();

        // Ensure the authenticated user matches the user in the invitation
        if ($authUser->id !== $user->id) {
            return redirect()->route('projects.index')->with('error', 'Unauthorized action.');
        }

        // Check if there is a pending invitation
        $invitation = $project->collaborators()->where('user_id', $authUser->id)->wherePivot('status', 'pending')->first();

        if (!$invitation) {
            return redirect()->route('projects.index')->with('error', 'No pending invitation found.');
        }

        // Remove the invitation
        $project->collaborators()->detach($authUser->id);

        // Notify the project owner
        $inviter = $project->owner;
        $inviter->notify(new ProjectInvitationResponseNotification($project, $authUser, 'declined'));

        // Redirect with a message
        return redirect()->route('projects.index')->with('info', 'You have declined the invitation.');
    }

    /**
     * Remove a collaborator from the project.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User     $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Project $project, User $user)
    {
        // Authorization: Only the project owner can remove collaborators
        $this->authorize('removeCollaborator', $project);

        // Prevent owner from being removed
        if ($user->id === $project->owner->id) {
            return redirect()->route('projects.show', $project)->with('error', 'Cannot remove the project owner.');
        }

        // Check if the user is a collaborator or has a pending invitation
        $collaboration = $project->collaborators()->where('user_id', $user->id)->first();

        if (!$collaboration) {
            return redirect()->route('projects.show', $project)->with('error', 'User is not a collaborator or does not have a pending invitation.');
        }

        // Detach the collaborator or pending invitation
        $project->collaborators()->detach($user->id);

        // Optionally, notify the removed collaborator
        $user->notify(new CollaboratorRemovedNotification($project, Auth::user()));

        return redirect()->route('projects.show', $project)->with('success', 'Collaborator or pending invitation removed successfully.');
    }
}
