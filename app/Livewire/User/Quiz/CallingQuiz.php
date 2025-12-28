<?php

namespace App\Livewire\User\Quiz;

use App\Models\Course;
use App\Models\Quiz;
use Livewire\Component;

class CallingQuiz extends Component
{
    public $search = '';
    public $courseFilter = 'all';

    public function render()
    {
        $quizzes = Quiz::with(['course', 'user'])
            ->where('is_published', true)
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->courseFilter !== 'all', function ($q) {
                $q->where('course_id', $this->courseFilter);
            })
            ->latest()
            ->get();

        return view('livewire.user.quiz.calling-quiz', [
            'quizzes' => $quizzes,
            'courses' => Course::select('id', 'course_name')->get(),
        ]);
    }
}
