<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Label;
use App\Models\ProjectTask;

class ProjectTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a project
        $project = Project::factory()->create(['user_id' => $user->id]);

        // Create a label
        $label = Label::factory()->create();

        // Simulate a POST request to store a new task
        $response = $this->post(route('projecttasks.store', $project->id), [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'due_date' => now()->addDays(2),
            'priority' => 'High',
            'label_id' => $label->id,
            'notes' => 'Some notes for the task.',
            'reminder' => true,
        ]);

        // Assert that the task was created and the user is redirected
        $response->assertRedirect(route('projects.show', $project->id));
        $this->assertDatabaseHas('project_tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'project_id' => $project->id,
        ]);
    }

    public function test_edit_task()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a project
        $project = Project::factory()->create(['user_id' => $user->id]);

        // Create a task
        $task = ProjectTask::factory()->create([
            'project_id' => $project->id,
            'title' => 'Original Title',
        ]);

        // Simulate a PUT request to update the task
        $response = $this->put(route('projecttasks.update', [$project->id, $task->id]), [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ]);

        // Assert that the task was updated and the user is redirected
        $response->assertRedirect(route('projects.show', $project->id));
        $this->assertDatabaseHas('project_tasks', [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ]);
    }

    public function test_delete_task()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a project
        $project = Project::factory()->create(['user_id' => $user->id]);

        // Create a task
        $task = ProjectTask::factory()->create([
            'project_id' => $project->id,
        ]);

        // Simulate a DELETE request to remove the task
        $response = $this->delete(route('projecttasks.destroy', [$project->id, $task->id]));

        // Assert that the task was deleted and the user is redirected
        $response->assertRedirect(route('projects.show', $project->id));
        $this->assertDatabaseMissing('project_tasks', [
            'id' => $task->id,
        ]);
    }
}
