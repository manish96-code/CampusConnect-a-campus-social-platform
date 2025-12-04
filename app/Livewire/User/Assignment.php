<?php

namespace App\Livewire\User;

use App\Models\Assignment as AssignmentModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]

class Assignment extends Component
{
    use WithFileUploads;

    public $title;
    public $course;
    public $due_date;
    public $description;
    public $file; 

    public $isCreating = false;        
    public $isSubmitting = false;     
    public $selectedAssignment = null;
    public $filter = 'all';

    public $submission_text;
    public $submission_file;

    protected $rules = [
        'title' => 'required|string|max:255',
        'course' => 'required|string|max:255',
        'due_date' => 'required|date',
        'description' => 'nullable|string|max:1000',
        'file' => 'nullable|file|max:10240', 
    ];

    protected $submissionRules = [
        'submission_text' => 'nullable|string|max:2000',
        'submission_file' => 'nullable|file|max:10240',
    ];


    public function toggleCreate()
    {
        $this->isCreating = ! $this->isCreating;
        $this->resetValidation();
        if ($this->isCreating) {
            $this->closeDetails();
        }
    }

    public function create()
    {
        $this->validate();

        $filePath = null;
        if ($this->file) {
            $filePath = $this->file->store('assignments', 'public');
        }

        AssignmentModel::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'course' => $this->course,
            'due_date' => $this->due_date,
            'description' => $this->description,
            'file' => $filePath,
            'status' => 'pending',
        ]);

        $this->reset(['title', 'course', 'due_date', 'description', 'file']);
        $this->isCreating = false;
        session()->flash('message', 'Assignment created successfully!');
    }


    public function showDetails($id)
    {
        $assignment = AssignmentModel::find($id);
        if (! $assignment) {
            session()->flash('message', 'Assignment not found.');
            return;
        }

        $this->selectedAssignment = $assignment;
        $this->isSubmitting = true;
        $this->reset(['submission_text', 'submission_file']);
        $this->resetValidation();
        $this->isCreating = false;
    }

    public function closeDetails()
    {
        $this->selectedAssignment = null;
        $this->isSubmitting = false;
        $this->reset(['submission_text', 'submission_file']);
    }

    public function submitAssignment()
    {
        if (! $this->selectedAssignment) {
            session()->flash('message', 'No assignment selected.');
            return;
        }

        $this->validate($this->submissionRules);

        if (! $this->submission_text && ! $this->submission_file) {
            $this->addError('submission', 'Please provide text or attach a file.');
            return;
        }

        $submissionPath = null;
        if ($this->submission_file) {
            $submissionPath = $this->submission_file->store('submissions', 'public');
        }

        $this->selectedAssignment->update([
            'submission_text' => $this->submission_text ?? $this->selectedAssignment->submission_text ?? null,
            'submission_file' => $submissionPath ?? $this->selectedAssignment->submission_file ?? null,
            'status' => 'completed',
        ]);

        $this->selectedAssignment->refresh();
        $this->reset(['submission_text', 'submission_file']);
        session()->flash('message', 'Assignment submitted successfully!');
    }


    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function render()
    {
        $query = AssignmentModel::query();

        $query->where('user_id', Auth::id());

        if ($this->filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($this->filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($this->filter === 'overdue') {
            $query->where('due_date', '<', now())->where('status', '!=', 'completed');
        }

        $assignments = $query->orderBy('due_date', 'asc')->get();

        return view('livewire.user.assignment', compact('assignments'));
    }
}
