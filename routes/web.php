<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\User\Assignment;
use App\Livewire\User\CourseView;
use App\Livewire\User\EventLive;
use App\Livewire\User\FindFriend;
use App\Livewire\User\Group\Profile as GroupProfile;
use App\Livewire\User\GroupView;
use App\Livewire\User\Home;
use App\Livewire\User\Library;
use App\Livewire\User\Post\CreatePost;
use App\Livewire\User\Profile;
use App\Livewire\User\Profile\MyProfile;
use App\Livewire\User\Quiz\AddQuestions;
use App\Livewire\User\Quiz\AttemptQuiz;
use App\Livewire\User\Quiz\CallingQuiz;
use App\Livewire\User\Quiz\CreateQuiz;
use App\Livewire\User\Quiz\ManageQuiz;
use App\Livewire\User\Quiz\QuizView;
use App\Livewire\User\Quiz\ResultQuiz;
use App\Livewire\User\Settings;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/profile/{id?}', Profile::class)->name('profile');
    Route::get('/find-friends', FindFriend::class)->name('find-friends');
    Route::get('library', Library::class)->name('library');
    Route::get('assignment', Assignment::class)->name('assignment');
    Route::get('/events', EventLive::class)->name('events');

    Route::get('/group', GroupView::class)->name('group');
    Route::get('/group-profile/{id}', GroupProfile::class)->name('group-profile');

    Route::get('/quiz', CallingQuiz::class)->name('quiz');
    Route::get('/quiz/create', CreateQuiz::class)->name('quiz.create');
    Route::get('/quiz/{quizId}/questions', AddQuestions::class)->name('quiz.questions');
    Route::get('/quiz/{quizId}/attempt', AttemptQuiz::class)->name('quiz.attempt');
    Route::get('/quiz/{quizId}/result/{attemptId?}', ResultQuiz::class)->name('quiz.result');
    Route::get('/quiz/{quizId}/manage', ManageQuiz::class)->name('quiz.manage');

    Route::get('/course', CourseView::class)->name('courses');

    Route::get('/settings', Settings::class)->name('settings');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});
