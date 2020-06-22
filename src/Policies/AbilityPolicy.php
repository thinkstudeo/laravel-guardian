<?php

namespace Thinkstudeo\Rakshak\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Thinkstudeo\Rakshak\Ability;

class AbilityPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the listing of Abilities.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->hasRole('rakshak');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \Thinkstudeo\Rakshak\Ability  $ability
     * @return mixed
     */
    public function view(User $user, Ability $ability)
    {
        return $user->hasRole('rakshak');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('rakshak');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @param  \Thinkstudeo\Rakshak\Ability  $ability
     * @return mixed
     */
    public function update(User $user, Ability $ability)
    {
        return $user->hasRole('rakshak');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @param  \Thinkstudeo\Rakshak\Ability  $ability
     * @return mixed
     */
    public function delete(User $user, Ability $ability)
    {
        return $user->hasRole('rakshak');
    }
}
