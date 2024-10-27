<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;  // Import the Task model

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Task $task)
    {
        return $task->user_id === $user->id;
    }
    


public function delete(User $user, Task $task)
{
    return $user->id === $task->user_id;
}

}
