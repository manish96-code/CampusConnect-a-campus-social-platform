<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class GroupButton extends Component
{
    public Group $group;
    public $targetUserId; // The user being acted upon (defaults to Auth user)
    public $status;       // 'not_member', 'pending', 'approved', 'admin'
    public $isGroupAdmin = false;

    public function mount(Group $group, $candidateId = null)
    {
        $this->group = $group;
        $this->targetUserId = $candidateId ?? Auth::id();
        
        // Check if the *Logged In* user is an admin of this group
        $this->isGroupAdmin = $this->group->members()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'admin')
            ->exists();

        $this->checkStatus();
    }

    // public function checkStatus()
    // {
    //     // Check the status of the *Target* user
    //     $member = $this->group->members()->where('users.id', $this->targetUserId)->first();
        
    //     if (!$member) {
    //         // Check pending requests
    //         $request = $this->group->requests()->where('users.id', $this->targetUserId)->first();
    //         $this->status = $request ? 'pending' : 'not_member';
    //     } else {
    //         // They are a member, check role
    //         $this->status = $member->pivot->role === 'admin' ? 'admin' : 'approved';
    //     }
    // }

    protected function checkStatus()
{
    // Find membership (this will return a User model if exists via belongsToMany)
    $member = $this->group->members()->where('user_id', $this->targetUserId)->first();

    if ($member) {
        // They are on the pivot table — examine pivot columns
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
        // Not on the pivot -> no membership and no pending request
        $this->status = 'not_member';
    }
}


    // --- USER ACTIONS (Managing Self) ---

    public function join()
    {
        if ($this->group->group_type === 'public') {
            // Join immediately
            $this->group->members()->attach(Auth::id(), ['role' => 'member', 'status' => 'approved']);
        } else {
            // Request to join
            $this->group->members()->attach(Auth::id(), ['role' => 'member', 'status' => 'pending']);
        }
        $this->checkStatus();
        $this->dispatch('group-updated'); // Optional: refresh parent
    }

    // public function cancelRequest()
    // {
    //     $this->group->members()->detach(Auth::id());
    //     $this->checkStatus();
    //     // $this->dispatch('group-updated');
    // }

    public function cancelRequest(){
        $this->group->requests()->detach(Auth::id());
        $this->checkStatus();
        $this->dispatch('group-updated');
    }

    public function leave_group(){
        if ($this->status === 'admin' && $this->group->members()->wherePivot('role', 'admin')->count() === 1) {
            session()->flash('error', 'You are the only admin. Delete the group instead.');
            return;
        }
        
        $this->group->members()->detach(Auth::id());
        $this->checkStatus();
        $this->dispatch('group-updated');
    }

    // ADMIN ACTIONS
    public function approve(){
        if (!$this->isGroupAdmin) return;
        
        $this->group->members()->updateExistingPivot($this->targetUserId, ['status' => 'approved']);
        $this->checkStatus();
    }

    public function reject()
    {
        if (!$this->isGroupAdmin) return;

        $this->group->members()->detach($this->targetUserId);
        $this->checkStatus();
    }

    public function removeUser()
    {
        if (!$this->isGroupAdmin) return;

        $this->group->members()->detach($this->targetUserId);
        $this->checkStatus();
    }

    public function render()
    {
        return view('livewire.user.group.group-button');
    }
}
