<?php

namespace App\Livewire\User\Quiz;

use App\Models\Course;
use App\Models\Quiz;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]


class CallingQuiz extends Component
{
    public $search = '';
    public $courseFilter = 'all';
    public $myQuiz = false;

    public function updatedMyQuiz()
    {
        $this->courseFilter = 'all';
    }

    public function render()
    {
        $quizzes = Quiz::with(['course', 'user', 'attempts'])
            ->where(function ($q) {
                $q->where('is_published', true)              // everyone
                    ->orWhere('user_id', auth()->id());        // creator see their unpublished)
            })
            ->when($this->myQuiz, function ($q) {
                $q->where('user_id', auth()->id());
            })
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
