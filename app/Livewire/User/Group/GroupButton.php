<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class GroupButton extends Component
{
    public Group $group;
    public $targetUserId;
    public $status;
    public $isGroupAdmin = false;

    public function mount(Group $group, $candidateId = null)
    {
        $this->group = $group;
        $this->targetUserId = $candidateId ?? Auth::id();

        $this->isGroupAdmin = $this->group->members()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'admin')
            ->exists();

        $this->checkStatus();
    }

    protected function checkStatus()
    {
        $member = $this->group->members()->where('user_id', $this->targetUserId)->first();

        if ($member) {
            $pivot = $member->pivot;
            $pivotStatus = $pivot->status ?? null;
            $pivotRole   = $pivot->role ?? null;

            if ($pivotStatus === 'pending') {
                $this->status = 'pending';
            } elseif ($pivotRole === 'admin') {
                $this->status = 'admin';
            } else {
                $this->status = 'approved';
            }
        } else {
            $this->status = 'not_member';
        }
    }

    // USER ACTIONS
    public function join()
    {
        if ($this->group->group_type === 'public') {
            // Join immediately
            $this->group->members()->attach(Auth::id(), ['role' => 'member', 'status' => 'approved']);
            $this->dispatch('toast', message: "Welcome to {$this->group->group_name}! 🎉", type: 'success');
        } else {
            // Request to join
            $this->group->members()->attach(Auth::id(), ['role' => 'member', 'status' => 'pending']);
            $this->dispatch('toast', message: 'Join request sent! Waiting for approval. ⏳', type: 'warning');
        }
        $this->checkStatus();
    }

    public function cancelRequest()
    {
        $this->group->members()->detach(Auth::id());
        $this->checkStatus();
        $this->dispatch('toast', message: 'Join request cancelled.', type: 'delete');
    }

    public function leave_group()
    {
        if ($this->status === 'admin' && $this->group->members()->wherePivot('role', 'admin')->count() === 1) {
            $this->dispatch('toast', message: 'You are the only admin. Delete the group instead.', type: 'error');
            return;
        }

        $this->group->members()->detach(Auth::id());
        $this->checkStatus();
        $this->dispatch('toast', message: 'You left the group.', type: 'delete');
    }

    // ADMIN ACTIONS
    public function approve()
    {
        if (!$this->isGroupAdmin) return;

        $this->group->members()->updateExistingPivot($this->targetUserId, ['status' => 'approved']);
        $this->checkStatus();
        $this->dispatch('toast', message: 'Member approved! ✅', type: 'success');
    }

    public function reject()
    {
        if (!$this->isGroupAdmin) return;

        $this->group->members()->detach($this->targetUserId);
        $this->checkStatus();
        $this->dispatch('toast', message: 'Request rejected.', type: 'delete');
    }

    public function removeUser()
    {
        if (!$this->isGroupAdmin) return;

        $this->group->members()->detach($this->targetUserId);
        $this->dispatch('group-updated');
        $this->dispatch('toast', message: 'User removed from group.', type: 'delete');
    }

    public function deleteGroup()
    {
        // if (!$this->isGroupAdmin) return;
        $this->authorize('delete', $this->group);

        $this->group->delete();

        $this->dispatch('toast', message: 'Group deleted successfully.', type: 'delete');

        return redirect()->route('group');
    }

    public function makeAdmin()
    {
        if (! $this->isGroupAdmin) return;

        GroupMember::where('group_id', $this->group->id)
            ->where('user_id', $this->targetUserId)
            ->update(['role' => 'admin']);

        $this->dispatch('group-updated');
        $this->checkStatus();
        $this->dispatch('toast', message: 'Role updated to Admin. 🛡️', type: 'success');
    }

    public function removeAdmin()
    {
        // if (! $this->isGroupAdmin) return;
        $this->authorize('manageMembers', [$this->group, $this->targetUserId]);

        // prevent self delete
        // if ($this->targetUserId === auth()->id()) return;

        GroupMember::where('group_id', $this->group->id)
            ->where('user_id', $this->targetUserId)
            ->update(['role' => 'member']);

        $this->dispatch('group-updated');
        $this->checkStatus();
        $this->dispatch('toast', message: 'Admin role removed.', type: 'warning');
    }


    public function render()
    {
        return view('livewire.user.group.group-button');
    }
}
