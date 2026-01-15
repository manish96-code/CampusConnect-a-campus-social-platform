<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GroupMembers extends Component{
    public Group $group;
    public $filter = 'approved';
    public $search = '';
    public bool $isAdmin = false;

    protected $listeners = ['group-updated' => '$refresh'];

    public function mount(Group $group){
        $this->group = $group;

        $this->isAdmin = $this->group->members()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'admin')
            ->wherePivot('status', 'approved')
            ->exists();
    }

    public function setFilter($filter){
        $this->filter = $filter;
        $this->search = '';
    }

    public function addMember($userId){
        if (! $this->isAdmin) return;

        $exists = GroupMember::where('group_id', $this->group->id)
            ->where('user_id', $userId)
            ->exists();

        if ($exists) return;

        GroupMember::create([
            'group_id' => $this->group->id,
            'user_id'  => $userId,
            'role'     => 'member',
            'status'   => 'approved',
        ]);

        $this->dispatch('toast', message: 'Member added successfully', type: 'success');
        $this->dispatch('group-updated');
    }

    public function render(){
        if ($this->filter === 'add') {

            $users = User::query()
                ->whereDoesntHave('groups', function ($q) {
                    $q->where('group_id', $this->group->id);
                })
                ->when($this->search, function ($q) {
                    $q->where(function ($qq) {
                        $qq->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('first_name')
                ->get();

            return view('livewire.user.group.group-members', [
                'members' => collect(),
                'users'   => $users,
            ]);
        }

        $members = $this->group->members()
            ->when($this->search, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            });

        if ($this->filter === 'admin') {
            $members->wherePivot('role', 'admin')
                ->wherePivot('status', 'approved');
        } elseif ($this->filter !== 'all') {
            $members->wherePivot('status', $this->filter);
        }

        return view('livewire.user.group.group-members', [
            'members' => $members->get(),
            'users'   => collect(),
        ]);
    }
}
