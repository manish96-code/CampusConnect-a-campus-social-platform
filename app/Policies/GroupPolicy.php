<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        return $group->creator_by === $user->id;
    }

    public function manageMembers(User $user, Group $group, int $targetUserId): bool
    {
        $userIsAdmin = $group->members()
            ->where('users.id', $user->id)
            ->wherePivot('role', 'admin')
            ->wherePivot('status', 'approved')
            ->exists();

        if (! $userIsAdmin) {
            return false;
        }

        if ($group->creator_by === $targetUserId) {
            return false;
        }

        $targetIsAdmin = $group->members()
            ->where('users.id', $targetUserId)
            ->wherePivot('role', 'admin')
            ->wherePivot('status', 'approved')
            ->exists();

        if ($targetIsAdmin) {
            return $group->creator_by === $user->id;
        }
        
        return true;
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        return false;
    }
}
