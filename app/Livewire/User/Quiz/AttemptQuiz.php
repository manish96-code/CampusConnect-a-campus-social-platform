<?php 

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout("components.layouts.user")]


class AttemptQuiz extends Component
{
    public $quizId;
    public Quiz $quiz;
    public $answers = [];
    public bool $submitted = false;
    public ?QuizAttempt $attempt = null;
    public $currentQuestionIndex = 0;

    public function mount($quizId)
    {
        if (!$quizId) {
            abort(404);
        }

        $this->quizId = $quizId;
        $this->quiz = Quiz::with('questions')->findOrFail($quizId);

        $this->attempt = QuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', Auth::id())
            ->first();

        if ($this->attempt) {
            $this->submitted = true;
            foreach ($this->attempt->answers as $ans) {
                $this->answers[$ans->quiz_question_id] = $ans->selected_option;
            }
        }
    }

    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < $this->quiz->questions->count()) {
            $this->currentQuestionIndex = $index;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->quiz->questions->count() - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function submitQuiz()
    {
        if ($this->submitted) {
            return;
        }

        DB::transaction(function () {

            $this->attempt = QuizAttempt::create([
                'quiz_id' => $this->quizId,
                'user_id' => Auth::id(),
                'score'   => 0,
            ]);

            $score = 0;

            foreach ($this->quiz->questions as $question) {
                $selected = $this->answers[$question->id] ?? null;

                if (!$selected) continue;

                $isCorrect = $selected === $question->correct_option;

                QuizAttemptAnswer::create([
                    'quiz_attempt_id'  => $this->attempt->id,
                    'quiz_question_id' => $question->id,
                    'selected_option'  => $selected,
                    'is_correct'       => $isCorrect,
                ]);

                if ($isCorrect) {
                    $score++;
                }
            }

            $this->attempt->update(['score' => $score]);
        });

        $this->submitted = true;

        $this->dispatch('openResultQuiz', $this->quizId);
    }

    public function render()
    {
        return view('livewire.user.quiz.attempt-quiz');
    }
}
