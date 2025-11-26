<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Validate;
use App\Models\User;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    #[Validate("required|string|max:25")]
    public $first_name;

    #[Validate("required|string|max:25")]
    public $last_name;

    #[Validate("required|date")]
    public $dob;

    #[Validate("required|string|in:male,female,other")]
    public $gender;

    #[Validate("required|email|max:50")]
    public $email;

    #[Validate('required|digits:10')]
    public $contact;


    #[Validate("required|string|min:8|max:255")]
    public $password;


    public function register()
    {
        $data = $this->validate();

        $newuser = User::create($data);
        $this->reset();

        // direct login after registration
        Auth::attempt(["email" => $data["email"], "password" => $data["password"]]);

        redirect()->route("home");
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}