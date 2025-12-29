<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Livewire\Component;

class ManageQuiz extends Component
{

    public $quizId;
    public Quiz $quiz;

    public $questions = [];

    public function mount($quizId)
    {
        $this->quizId = $quizId;

        $this->quiz = Quiz::with(['course', 'attempts.user', 'questions'])
            ->findOrFail($quizId);

        foreach ($this->quiz->questions as $q) {
            $this->questions[] = [
                'id'       => $q->id,
                'question' => $q->question,
                'options'  => [
                    $q->option_a,
                    $q->option_b,
                    $q->option_c,
                    $q->option_d,
                ],
                'correct'  => array_search($q->correct_option, ['A', 'B', 'C', 'D']),
            ];
        }
    }

    public function saveQuestions()
    {
        foreach ($this->questions as $q) {
            QuizQuestion::where('id', $q['id'])->update([
                'question'       => $q['question'],
                'option_a'       => $q['options'][0],
                'option_b'       => $q['options'][1],
                'option_c'       => $q['options'][2],
                'option_d'       => $q['options'][3],
                'correct_option' => ['A', 'B', 'C', 'D'][$q['correct']],
            ]);
        }

        session()->flash('message', 'Questions updated successfully ✅');
    }

    public function deleteQuiz()
    {
        $this->quiz->delete();
        $this->dispatch('quizDeleted');
    }


    public $newQuestion = [
        'question' => '',
        'options' => ['', '', '', ''],
        'correct' => 0,
    ];

    public function addQuestion()
    {
        QuizQuestion::create([
            'quiz_id'        => $this->quiz->id,
            'question'       => $this->newQuestion['question'],
            'option_a'       => $this->newQuestion['options'][0],
            'option_b'       => $this->newQuestion['options'][1],
            'option_c'       => $this->newQuestion['options'][2],
            'option_d'       => $this->newQuestion['options'][3],
            'correct_option' => ['A', 'B', 'C', 'D'][$this->newQuestion['correct']],
        ]);

        $this->newQuestion = [
            'question' => '',
            'options' => ['', '', '', ''],
            'correct' => 0,
        ];

        session()->flash('message', 'Question added successfully ✅');
    }

    public function deleteQuestion($questionId)
    {
        QuizQuestion::where('id', $questionId)->delete();

        session()->flash('message', 'Question deleted successfully ❌');
    }


    public function render()
    {
        return view('livewire.user.quiz.manage-quiz');
    }
}
