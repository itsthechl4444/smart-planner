<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaborationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_invite_up_to_three_collaborators()
    {
        // Create a user and project
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);

        // Simulate logging in as the owner
        $this->actingAs($owner);

        // Invite 3 collaborators
        for ($i = 1; $i <= 3; $i++) {
            $collaborator = User::factory()->create();
            $response = $this->post(route('collaborations.invite', $project->id), [
                'email' => $collaborator->email,
            ]);
            $response->assertStatus(200); // or the appropriate success status
        }

        // Attempt to invite a fourth collaborator
        $fourthCollaborator = User::factory()->create();
        $response = $this->post(route('collaborations.invite', $project->id), [
            'email' => $fourthCollaborator->email,
        ]);
        $response->assertSessionHasErrors(['email']); // Check for error in session
        $this->assertEquals(3, $project->collaborators()->count()); // Ensure only 3 collaborators
    }
}
