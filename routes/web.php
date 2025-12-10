<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\User\Assignment;
use App\Livewire\User\EventLive;
use App\Livewire\User\FindFriend;
use App\Livewire\User\GroupView;
use App\Livewire\User\Home;
use App\Livewire\User\Library;
use App\Livewire\User\Post\CreatePost;
use App\Livewire\User\Profile;
use App\Livewire\User\Profile\MyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function(){
    Route::get('/', Home::class)->name('home');
    Route::get('/profile/{id?}', Profile::class)->name('profile');
    Route::get('/find-friends', FindFriend::class)->name('find-friends');
    Route::get('library', Library::class)->name('library');
    Route::get('assignment', Assignment::class)->name('assignment');
    Route::get('/events', EventLive::class)->name('events');
    Route::get('/group', GroupView::class)->name('group');
    Route::get('/logout', function(){
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Route::middleware('guest')->group(function(){
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

