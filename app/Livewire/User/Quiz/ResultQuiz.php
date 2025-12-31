<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]


class ResultQuiz extends Component
{
    public $quizId;
    public $attemptId = null;

    public Quiz $quiz;
    public QuizAttempt $attempt;

    public $totalQuestions;
    public $correct;
    public $wrong;
    public $scorePercentage;
    public $isPassed;

    public function mount($quizId, $attemptId = null)
    {
        $this->quizId = $quizId;
        $this->attemptId = $attemptId;

        $this->quiz = Quiz::with('questions')->findOrFail($quizId);

        if ($this->attemptId) {
            $this->attempt = QuizAttempt::with(['answers', 'user'])
                ->where('id', $this->attemptId)
                ->where('quiz_id', $quizId)
                ->firstOrFail();

            if ($this->attempt->user_id !== auth()->id() && $this->quiz->user_id !== auth()->id() && !auth()->user()->isAdmin) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            $this->attempt = QuizAttempt::with(['answers', 'user'])
                ->where('quiz_id', $quizId)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        // Calculations
        $this->totalQuestions = $this->quiz->questions->count();
        $this->correct = $this->attempt->score;
        $this->wrong = $this->totalQuestions - $this->correct;

        $this->scorePercentage = round(
            ($this->correct / max($this->totalQuestions, 1)) * 100
        );

        $this->isPassed = $this->scorePercentage >= 40;
    }

    public function render()
    {
        return view('livewire.user.quiz.result-quiz');
    }
}
