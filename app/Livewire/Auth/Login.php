<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|email|max:50')]
    public $email;

    #[Validate('required|string|min:8|max:16')]
    public $password;

    public function login()
    {
        $data = $this->validate();

        if (Auth::attempt($data)) {
            $this->dispatch('toast', message: 'Welcome back! 👋', type: 'success');

            if (auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        $userExists = User::where('email', $this->email)->exists();

        if (!$userExists) {
            // unregistered email
            $this->addError('email', 'This email is not registered.');
            $this->dispatch('toast', message: 'Account not found.', type: 'error');
        } else {
            // wrong password
            $this->addError('password', 'The password you entered is incorrect.');
            $this->dispatch('toast', message: 'Incorrect password.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
