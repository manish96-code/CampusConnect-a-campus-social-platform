<?php
namespace App\Providers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
{
    Gate::define('delete-group', function (User $user, Group $group) {
        return $group->created_by == $user->id;
    });

    Gate::define('manage-group-members', function (User $user, Group $group, int $targetUserId) {
        // Is current user an admin?
        $userIsAdmin = $group->members()
            ->where('users.id', $user->id)
            ->wherePivot('role', 'admin')
            ->wherePivot('status', 'approved')
            ->exists();

        if (!$userIsAdmin) return false;

        // Nobody manages the Creator
        if ($group->created_by == $targetUserId) return false;

        // Is target an admin?
        $targetIsAdmin = $group->members()
            ->where('users.id', $targetUserId)
            ->wherePivot('role', 'admin')
            ->exists();

        if ($targetIsAdmin) {
            // Only the creator can demote/remove other admins
            return $group->created_by == $user->id;
        }

        return true; 
    });
}
}