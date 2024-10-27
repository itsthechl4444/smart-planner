<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the income.
     */
    public function view(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }

    /**
     * Determine whether the user can update the income.
     */
    public function update(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }

    /**
     * Determine whether the user can delete the income.
     */
    public function delete(User $user, Income $income)
    {
        return $user->id === $income->user_id;
    }
}
