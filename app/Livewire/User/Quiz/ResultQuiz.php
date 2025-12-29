<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ResultQuiz extends Component
{
    public $quizId;
    public Quiz $quiz;
    public QuizAttempt $attempt;

    public $totalQuestions;
    public $correct;
    public $wrong;
    public $scorePercentage;
    public $isPassed;

    public function mount($quizId)
    {
        $this->quizId = $quizId;

        $this->quiz = Quiz::with('questions')->findOrFail($quizId);

        $this->attempt = QuizAttempt::with('answers')
            ->where('quiz_id', $quizId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->totalQuestions = $this->quiz->questions->count();
        $this->correct = $this->attempt->score;
        $this->wrong = $this->totalQuestions - $this->correct;

        $this->scorePercentage = round(
            ($this->correct / max($this->totalQuestions, 1)) * 100
        );

        // pass if >= 40%
        $this->isPassed = $this->scorePercentage >= 40;
    }

    public function render()
    {
        return view('livewire.user.quiz.result-quiz');
    }
}
