<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CallingGroup extends Component
{
    public $filter = 'all';

    public function joinGroup($groupId){
        $group = Group::find($groupId);

        $userId = Auth::id();

        $exists = GroupMember::where('group_id', $group->id)
            ->where('user_id', $userId)
            ->exists();

        if ($exists) {
            session()->flash('message', 'You are already a member or have a pending request for this group.');
            return;
        }

        $role = 'member';
        $status = $group->group_type === 'private' ? 'pending' : 'approved';

        GroupMember::create([
            'group_id' => $group->id,
            'user_id'  => $userId,
            'role'     => $role,
            'status'   => $status,
        ]);

        session()->flash('message', $status === 'approved' ? 'You joined the group.' : 'Join request sent — waiting for approval.');
    }

    public function render()
    {
        $query = Group::with('creator');

        if ($this->filter === 'my_groups') {
            $query->where('created_by', Auth::id());
        } elseif ($this->filter === 'public') {
            $query->where('group_type', 'public');
        }

        $groups = $query->latest()->get();

        return view('livewire.user.group.calling-group', [
            'groups' => $groups,
        ]);
    }
}
