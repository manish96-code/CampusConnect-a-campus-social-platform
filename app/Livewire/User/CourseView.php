<?php

namespace App\Livewire\User;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("components.layouts.user")]
class CourseView extends Component
{
    public $filter = 'my'; // my | all
    public $search = '';

    public function setFilter($type)
    {
        $this->filter = $type;
    }

    public function enroll($courseId)
    {
        auth()->user()
            ->courses()
            ->syncWithoutDetaching([$courseId]); // prevents duplicate enroll
    }

    public function render()
    {
        $user = auth()->user();

        if ($this->filter === 'my') {
            $courses = $user->courses()
                ->where('course_name', 'like', '%' . $this->search . '%')
                ->get();
        } else {
            $courses = Course::where('course_name', 'like', '%' . $this->search . '%')->get();
        }

        return view('livewire.user.course-view', compact('courses', 'user'));
    }
}
