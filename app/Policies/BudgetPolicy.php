<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Budget $budget)
    {
        return $user->id === $budget->user_id;
    }

    public function delete(User $user, Budget $budget)
    {
        return $user->id === $budget->user_id;
    }
}
