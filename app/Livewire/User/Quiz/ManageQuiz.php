<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]

class ManageQuiz extends Component{

    public $quizId;
    public Quiz $quiz;
    public $questions = [];

    public function mount($quizId){
        $this->quizId = $quizId;
        $this->loadQuizData();
    }

    // Load/refresh quiz data
    public function loadQuizData(){
        $this->quiz = Quiz::with(['course', 'attempts.user', 'questions'])
            ->findOrFail($this->quizId);

        $this->questions = [];
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

    public function syncTotalMarks(){
        $count = QuizQuestion::where('quiz_id', $this->quiz->id)->count();
        $shouldBePublished = $count > 0;

        $this->quiz->update([
            'total_marks' => $count,
            'is_published' => $shouldBePublished
        ]);
        $this->quiz->refresh();
    }

    public function addNewQuestion(){
        QuizQuestion::create([
            'quiz_id'        => $this->quiz->id,
            'question'       => $this->newQuestion['question'],
            'option_a'       => $this->newQuestion['options'][0],
            'option_b'       => $this->newQuestion['options'][1],
            'option_c'       => $this->newQuestion['options'][2],
            'option_d'       => $this->newQuestion['options'][3],
            'correct_option' => ['A', 'B', 'C', 'D'][$this->newQuestion['correct']],
        ]);

        $this->syncTotalMarks();
        $this->loadQuizData();

        $this->newQuestion = [
            'question' => '',
            'options' => ['', '', '', ''],
            'correct' => 0,
        ];

        $this->dispatch('toast', message: 'New question added successfully! ✅', type: 'success');
    }

    public function deleteQuestion($questionId){
        QuizQuestion::where('id', $questionId)->delete();

        $this->syncTotalMarks();
        $this->loadQuizData();

        $this->dispatch('toast', message: 'Question removed from the quiz.', type: 'delete');
    }

    public function updateQuiz(){
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

        $this->syncTotalMarks();
        $this->dispatch('toast', message: 'All changes saved successfully! 💾', type: 'success');
    }

    public function deleteQuiz(){
        $this->quiz->delete();
        $this->dispatch('toast', message: 'The quiz has been deleted.', type: 'delete');
        return redirect()->route('quiz');
    }

    public $newQuestion = [
        'question' => '',
        'options' => ['', '', '', ''],
        'correct' => 0,
    ];

    public function render()
{
        return view('livewire.user.quiz.manage-quiz');
    }
}
