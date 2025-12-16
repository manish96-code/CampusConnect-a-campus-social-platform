<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
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

    protected function checkStatus(){
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
        } else {
            // Request to join
            $this->group->members()->attach(Auth::id(), ['role' => 'member', 'status' => 'pending']);
        }
        $this->checkStatus();
    }

    // public function cancelRequest()
    // {
    //     $this->group->members()->detach(Auth::id());
    //     $this->checkStatus();
    //     // 
    // }

    public function cancelRequest(){
        $this->group->members()->detach(Auth::id());
        $this->checkStatus();
        
    }

    public function leave_group(){
        if ($this->status === 'admin' && $this->group->members()->wherePivot('role', 'admin')->count() === 1) {
            session()->flash('error', 'You are the only admin. Delete the group instead.');
            return;
        }
        
        $this->group->members()->detach(Auth::id());
        $this->checkStatus();
        
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
