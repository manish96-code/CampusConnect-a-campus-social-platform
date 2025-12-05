<?php

namespace App\Livewire\User;

use App\Models\Assignment as AssignmentModel;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]
class Assignment extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public $title;
    #[Validate('required|string|max:255')]
    public $course;
    #[Validate('nullable|string|max:1000')]
    public $description;
    #[Validate('required|date')]
    public $due_date;
    #[Validate('nullable|file|max:10240')]
    public $file; 

    #[Validate('nullable|string|max:2000')]
    public $submission_text;
    #[Validate('nullable|file|max:10240')]
    public $submission_file;

    public $isCreating = false;
    public $selectedAssignmentId = null;
    public $filter = 'all';

    public function toggleCreate()
    {
        $this->isCreating = !$this->isCreating;
        $this->selectedAssignmentId = null;
        $this->resetValidation();
        $this->reset(['title', 'course', 'description', 'due_date', 'file']);
    }

    public function create()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'due_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = $this->file ? $this->file->store('assignments', 'public') : null;

        AssignmentModel::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'course' => $this->course,
            'due_date' => $this->due_date,
            'description' => $this->description,
            'file' => $filePath,
            'status' => 'pending',
        ]);

        $this->isCreating = false;
        session()->flash('message', 'Assignment created successfully!');
    }

    public function showDetails($id)
    {
        $this->selectedAssignmentId = $id;
        $this->isCreating = false;
        $this->reset(['submission_text', 'submission_file']);

        $assignment = AssignmentModel::find($id);
        if ($assignment && $assignment->my_submission) {
            $this->submission_text = $assignment->my_submission->submission_text;
        }
    }

    public function closeDetails()
    {
        $this->selectedAssignmentId = null;
    }

    public function submitAssignment()
    {
        if (!$this->selectedAssignmentId) return;

        $this->validate([
            'submission_text' => 'nullable|string|max:2000',
            'submission_file' => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($this->submission_file) {
            $filePath = $this->submission_file->store('submissions', 'public');
        }

        AssignmentSubmission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'assignment_id' => $this->selectedAssignmentId
            ],
            [
                'submission_text' => $this->submission_text,
                'file' => $filePath,
                'status' => 'submitted',
            ]
        );

        $this->reset(['submission_file']);
        session()->flash('message', 'Work submitted successfully!');
    }

    public function delete($id)
    {
        $assignment = AssignmentModel::find($id);
        if ($assignment && $assignment->user_id === Auth::id()) {
            $assignment->delete();
            $this->selectedAssignmentId = null;
        }
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function render()
    {
        $query = AssignmentModel::with(['user', 'my_submission']);

        if ($this->filter === 'pending') {
            $query->whereDoesntHave('my_submission');
        } elseif ($this->filter === 'completed') {
            $query->whereHas('my_submission');
        }

        $assignments = $query->orderBy('due_date', 'asc')->get();

        $selectedAssignment = $this->selectedAssignmentId 
            ? AssignmentModel::with('my_submission')->find($this->selectedAssignmentId) 
            : null;

        return view('livewire.user.assignment', [
            'assignments' => $assignments,
            'selectedAssignment' => $selectedAssignment
        ]);
    }
}