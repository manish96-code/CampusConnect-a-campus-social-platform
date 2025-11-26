<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{

    #[Validate("required|email|max:50")]
    public $email;

    #[Validate("required|string|min:8|max:16")]
    public $password;

    public function login()
    {
        $data = $this->validate();

        if (Auth::attempt($data)) {
            return redirect()->route('home');
        }

        $this->addError('email', 'Invalid email or password.');
        // $this->addError('email', 'Invalid email.');
        // $this->addError('password', 'wrong password.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}