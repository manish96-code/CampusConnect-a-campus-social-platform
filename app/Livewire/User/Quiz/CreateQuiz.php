<?php

namespace App\Livewire\User\Quiz;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateQuiz extends Component
{
    public $title;
    public $description;
    public $total_marks = 10;
    public $course_id;

    public $courses = [];

    protected $rules = [
        'course_id'   => 'required|exists:courses,id',
        'title'       => 'required|min:3|max:150',
        'description' => 'nullable|max:500',
        'total_marks' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->courses = Course::select('id', 'course_name')->get();
    }

    public function save()
    {
        $this->validate();

        $quiz = Quiz::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'total_marks' => $this->total_marks,
            'course_id' => $this->course_id,
        ]);

        // 🔥 EMIT EVENT INSTEAD OF REDIRECT
        $this->dispatch('quiz-created', $quiz->id);

        // $this->reset();
    }


    public function render()
    {
        return view('livewire.user.quiz.create-quiz');
    }
}
