<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the account.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Account $account)
    {
        return $user->id === $account->user_id;
    }

    /**
     * Determine whether the user can update the account.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Account $account)
    {
        return $user->id === $account->user_id;
    }

    /**
     * Determine whether the user can delete the account.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Account $account)
    {
        return $user->id === $account->user_id;
    }
}
