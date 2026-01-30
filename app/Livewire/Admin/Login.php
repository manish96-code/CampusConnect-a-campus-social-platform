<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Login extends Component
{
    #[Validate('required|email')]
    public $email;

    #[Validate('required|string')]
    public $password;

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = auth()->user();

            if ($user->is_admin) {
                $this->dispatch('toast', message: 'Admin access granted. Welcome back!', type: 'success');
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            $this->addError('email', 'You do not have administrative privileges.');
            $this->dispatch('toast', message: 'Access denied.', type: 'error');
            return;
        }

        $this->addError('email', 'Invalid credentials.');
        $this->dispatch('toast', message: 'Authentication failed.', type: 'error');
    }

    public function render()
    {
        return view('livewire.admin.login');
    }
}
