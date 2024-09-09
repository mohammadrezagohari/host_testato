<?php

namespace App\Policies;

use App\Enums\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class WalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Wallet $wallet
     * @return Response|bool
     */
    public function view(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->user_id || $user->hasRole(Roles::SuperLevel);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Wallet $wallet
     * @return Response|bool
     */
    public function update(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->user_id || $user->hasRole(Roles::SuperLevel);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Wallet $wallet
     * @return Response|bool
     */
    public function delete(User $user, Wallet $wallet)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Wallet $wallet
     * @return Response|bool
     */
    public function restore(User $user, Wallet $wallet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Wallet $wallet
     * @return Response|bool
     */
    public function forceDelete(User $user, Wallet $wallet)
    {
        //
    }
}
