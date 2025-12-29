<?php

namespace App\Livewire\User\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]
class QuizView extends Component
{
    public $tab = 'list';
    public $quizId = null;
    protected $listeners = [
        'openAttemptQuiz' => 'openAttemptQuiz',
        'openResultQuiz'  => 'openResultQuiz',
        'openManageQuiz'  => 'openManageQuiz',
        'quiz-created'    => 'quizCreated',
        'reviewQuizAnswer' => 'reviewQuizAnswer',
    ];


    public function reviewQuizAnswer($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'reviewAns';
    }


    public function openAttemptQuiz($quizId)
    {
        $this->quizId = $quizId;
        $this->tab = 'attempt';
    }

    // #[On('reviewQuizAnswer')]
    // public function openReview($quizId)
    // {
    //     $this->quizId = $quizId;
    //     $this->showAttempt = false;
    //     $this->showResult = false;
    //     $this->showReview = true;
    // }

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
