<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CallingGroup extends Component
{
    public $filter = 'all';

    public function joinGroup($groupId)
    {
        $group = Group::findOrFail($groupId);
        $userId = Auth::id();

        $exists = GroupMember::where('group_id', $group->id)
            ->where('user_id', $userId)
            ->exists();

        if ($exists) {
            session()->flash('message', 'You are already a member or request is pending.');
            return;
        }

        $status = $group->group_type === 'private' ? 'pending' : 'approved';

        GroupMember::create([
            'group_id' => $group->id,
            'user_id'  => $userId,
            'role'     => 'member',
            'status'   => $status,
        ]);

        session()->flash(
            'message',
            $status === 'approved'
                ? 'You joined the group.'
                : 'Join request sent — waiting for approval.'
        );
    }

    public function render()
    {
        $query = Group::with([
                'creator',
                'members' => function ($q) {
                    $q->wherePivot('status', 'approved')
                      ->select('users.id', 'first_name', 'dp');
                }
            ])
            ->withCount([
                'members as members_count' => function ($q) {
                    $q->where('status', 'approved');
                }
            ]);

        if ($this->filter === 'my_groups') {
            $query->whereHas('members', function ($q) {
                $q->where('users.id', Auth::id())
                  ->where('status', 'approved');
            });
        } elseif ($this->filter === 'public') {
            $query->where('group_type', 'public');
        }

        return view('livewire.user.group.calling-group', [
            'groups' => $query->latest()->get(),
        ]);
    }
}
