<?php

namespace App\Livewire\User\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout("components.layouts.user")]
class QuizView extends Component
{
    public $tab = 'list';
    public $quizId = null;
    public $attemptId = null;

    #[On('openAttemptQuiz')]
    public function openAttemptQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'attempt';
    }

    #[On('openResultQuiz')]
    public function openResultQuiz($quizId, $attemptId = null)
    {
        $this->quizId = $quizId;
        $this->attemptId = $attemptId;
        $this->tab = 'result';
    }

    #[On('openManageQuiz')]
    public function openManageQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'manage';
    }

    #[On('quiz-created')]
    public function quizCreated($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'questions';
    }

    public function render()
    {
        return view('livewire.user.quiz.quiz-view');
    }
}
