<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AddQuestions extends Component
{
    public Quiz $quiz;
    public $questions = [];

    protected $rules = [
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string',
        'questions.*.options' => 'required|array|size:4',
        'questions.*.options.*' => 'required|string',
        'questions.*.correct' => 'required|integer|between:0,3',
    ];

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
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
                    'correct_option' => ['A','B','C','D'][$q['correct']],
                ]);
            }

            // ✅ PUBLISH QUIZ
            $this->quiz->update([
                'is_published' => true
            ]);
        });

        session()->flash('message', 'Quiz published successfully ✅');

        return redirect()->route('quiz');
    }

    public function render()
    {
        return view('livewire.user.quiz.add-questions');
    }
}
