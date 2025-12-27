<?php

namespace App\Livewire\User\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]
class QuizView extends Component
{
    public $tab = 'list'; // list | create | attempt | result | manage | questions
    public $quizId = null;
    protected $listeners = [
        'openAttemptQuiz' => 'openAttemptQuiz',
        'openResultQuiz'  => 'openResultQuiz',
        'openManageQuiz'  => 'openManageQuiz',
        'quiz-created'    => 'quizCreated',
    ];

    public function openAttemptQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'attempt';
    }

    public function openResultQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'result';
    }

    public function openManageQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'manage';
    }

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
