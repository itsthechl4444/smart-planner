<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $collaborator;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Project $project, User $collaborator)
    {
        $this->project = $project;
        $this->collaborator = $collaborator;
        $this->user = Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Project Collaboration Invitation')
                    ->view('emails.project_invitation');
    }
}