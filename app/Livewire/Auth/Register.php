<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    #[Validate("required|string|regex:/^[a-zA-Z'-]+$/|max:25")]
    public $first_name;

    #[Validate("required|string|regex:/^[a-zA-Z'-]+$/|max:25")]
    public $last_name;

    #[Validate('required|date')]
    public $dob;

    #[Validate('required|string|in:male,female,other')]
    public $gender;

    #[Validate('required|email|max:50|unique:users,email')]
    public $email;

    #[Validate('required|regex:/^\+?[6-9]{1}[0-9]{9}$/')]
    public $contact;

    #[Validate('required|string|min:8|max:255')]
    public $password;

    public function register()
    {
        $data = $this->validate();

        $user = User::create($data);

        // direct login after registration
        // Auth::attempt(["email" => $data["email"], "password" => $data["password"]]);
        Auth::login($user);

        $this->dispatch('toast', message: 'Welcome to Campus Connect, '.$user->first_name.'! 👋', type: 'success');

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
