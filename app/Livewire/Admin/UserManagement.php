<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = 'all'; // all | admin | user

    protected $updatesQueryString = ['search', 'filterRole'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleAdmin($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent self-demotion if the logged in user is the one being toggled
        if ($user->id === auth()->id()) {
            $this->dispatch('toast', message: 'You cannot change your own admin status!', type: 'error');
            return;
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $this->dispatch('toast', message: 'User role updated successfully!', type: 'success');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            $this->dispatch('toast', message: 'You cannot delete yourself!', type: 'error');
            return;
        }

        $user->delete();
        $this->dispatch('toast', message: 'User deleted successfully!', type: 'delete');
    }

    public function render()
    {
        $query = User::query()
            ->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });

        if ($this->filterRole === 'admin') {
            $query->where('is_admin', true);
        } elseif ($this->filterRole === 'user') {
            $query->where('is_admin', false);
        }

        $users = $query->latest()->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users
        ]);
    }
}
