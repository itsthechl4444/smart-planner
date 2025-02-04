<?php

namespace App\Policies;

use App\Models\Debt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DebtPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any debts.
     */
    public function viewAny(User $user)
    {
        return true; // Adjust as needed
    }

    /**
     * Determine whether the user can view the debt.
     */
    public function view(User $user, Debt $debt)
    {
        return $user->id === $debt->user_id;
    }

    /**
     * Determine whether the user can create debts.
     */
    public function create(User $user)
    {
        return true; // Allow all authenticated users to create debts
    }

    /**
     * Determine whether the user can update the debt.
     */
    public function update(User $user, Debt $debt)
    {
        return $user->id === $debt->user_id;
    }

    /**
     * Determine whether the user can delete the debt.
     */
    public function delete(User $user, Debt $debt)
    {
        return $user->id === $debt->user_id;
    }

    // Add other methods as needed...
}
