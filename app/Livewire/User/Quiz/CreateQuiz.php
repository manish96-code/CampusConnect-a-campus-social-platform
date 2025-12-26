<?php

namespace App\Livewire\User\Quiz;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateQuiz extends Component
{
    public $title;
    public $description;
    public $total_marks = 10;

    public $questions = [];

    public $course_id;
    public $courses = [];

    protected $rules = [
        'title' => 'required|min:3|max:150',
        'description' => 'nullable|max:500',
        'total_marks' => 'required|integer|min:1',
        'course_id' => 'required|exists:courses,id',

        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string',
        'questions.*.options' => 'required|array|size:4',
        'questions.*.options.*' => 'required|string',
        'questions.*.correct' => 'required|integer|between:0,3',
    ];

    public function mount()
    {
        $this->courses = Course::all();
        $this->addQuestion();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'options' => ['', '', '', ''],
            'correct' => 0,
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

            $quiz = Quiz::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'total_marks' => $this->total_marks,
                'course_id' => $this->course_id,
            ]);

            foreach ($this->questions as $q) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $q['question'],
                    'option_a' => $q['options'][0],
                    'option_b' => $q['options'][1],
                    'option_c' => $q['options'][2],
                    'option_d' => $q['options'][3],
                    'correct_option' => ['A', 'B', 'C', 'D'][$q['correct']],
                ]);
            }
        });

        session()->flash('message', 'Quiz created successfully ✅');

        return redirect()->route('quiz');
    }

    public function render()
    {
        return view('livewire.user.quiz.create-quiz');
    }
}
