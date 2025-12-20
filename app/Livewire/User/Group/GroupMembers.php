<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GroupMembers extends Component
{
    public Group $group;
    public $filter = 'approved';
    public $search = '';
    public bool $isAdmin = false;

    protected $listeners = ['group-updated' => '$refresh'];

    public function mount(Group $group)
{
    $this->group = $group;

    $this->isAdmin = $this->group->members()
        ->where('users.id', Auth::id())
        ->wherePivot('role', 'admin')
        ->wherePivot('status', 'approved')
        ->exists();
}



    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function render()
{
    $membersQuery = $this->group->members()
        ->where(function ($q) {
            $q->where('first_name', 'like', '%' . $this->search . '%')
              ->orWhere('last_name', 'like', '%' . $this->search . '%');
        });

    if ($this->filter === 'admin') {
        $membersQuery
            ->wherePivot('role', 'admin')
            ->wherePivot('status', 'approved');
    } elseif ($this->filter !== 'all') {
        $membersQuery->wherePivot('status', $this->filter);
    }

    return view('livewire.user.group.group-members', [
        'members' => $membersQuery->get(),
    ]);
}

}
