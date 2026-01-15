<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout("components.layouts.user")]


class AddQuestions extends Component
{
    public Quiz $quiz;
    public $quizId;
    public $questions = [];

    protected $rules = [
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string',
        'questions.*.options' => 'required|array|size:4',
        'questions.*.options.*' => 'required|string',
        'questions.*.correct' => 'required|integer|between:0,3',
    ];

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $this->quiz = Quiz::findOrFail($quizId);
        $this->addQuestion();
    }


    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'options'  => ['', '', '', ''],
            'correct'  => 0,
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
        $this->dispatch('toast', message: 'Question removed from list.', type: 'warning');
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {

            foreach ($this->questions as $q) {
                QuizQuestion::create([
                    'quiz_id'        => $this->quiz->id,
                    'question'       => $q['question'],
                    'option_a'       => $q['options'][0],
                    'option_b'       => $q['options'][1],
                    'option_c'       => $q['options'][2],
                    'option_d'       => $q['options'][3],
                    'correct_option' => ['A', 'B', 'C', 'D'][$q['correct']],
                ]);
            }

            $this->quiz->update([
                'total_marks' => count($this->questions),
                'is_published' => true
            ]);
        });

        $this->dispatch('toast', message: 'Quiz published successfully! 🚀', type: 'success');

        return redirect()->route('quiz');
    }

    public function render()
    {
        return view('livewire.user.quiz.add-questions');
    }
}
