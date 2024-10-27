<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Debt;

class DebtPolicy
{
    public function view(User $user, Debt $debt)
    {
        return $user->id === $debt->user_id;
    }

    public function update(User $user, Debt $debt)
    {
        return $user->id === $debt->user_id;
    }

    public function delete(User $user, Debt $debt)
    {
        return $user->id === $debt->user_id;
    }
}
