<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CallingGroup extends Component
{
    public $filter = 'all';
    public $search = '';

    public function joinGroup($groupId)
    {
        $group = Group::findOrFail($groupId);
        $userId = Auth::id();

        $exists = GroupMember::where('group_id', $group->id)
            ->where('user_id', $userId)
            ->exists();

        if ($exists) {
            $this->dispatch('toast', message: 'You are already a member or request is pending.', type: 'warning');
            return;
        }

        $status = $group->group_type === 'private' ? 'pending' : 'approved';

        GroupMember::create([
            'group_id' => $group->id,
            'user_id'  => $userId,
            'role'     => 'member',
            'status'   => $status,
        ]);

        $this->dispatch('toast', message: $status === 'approved' ? 'You joined the group.' : 'Join request sent — waiting for approval.', type: 'success');
    }

    public function updatedSearch()
    {
        if ($this->search !== '') {
            $this->filter = 'all';
        }
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
            ])
            ->when($this->search, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('group_name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            });

        if ($this->filter === 'my_groups') {
            $query->whereHas('members', function ($q) {
                $q->where('users.id', Auth::id())
                    ->where('status', 'approved');
            });
        } elseif ($this->filter === 'public') {
            $query->where('group_type', 'public');
        } elseif ($this->filter === 'private') {
            $query->where('group_type', 'private');
        }

        return view('livewire.user.group.calling-group', [
            'groups' => $query->latest()->get(),
        ]);
    }
}
