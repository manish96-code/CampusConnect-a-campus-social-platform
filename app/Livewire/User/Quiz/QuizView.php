<?php

namespace App\Livewire\User\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout("components.layouts.user")]
class QuizView extends Component
{
    public function render()
    {
        return view('livewire.user.quiz.quiz-view');
    }
}
