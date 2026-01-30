<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Services\ImageKitService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.admin')]
class CourseManagement extends Component
{
    use WithFileUploads;

    public $courses;
    public $course_name, $description, $image, $course_id;
    public $isEdit = false;
    public $showModal = false;

    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::latest()->get();
    }

    public function rules()
    {
        return [
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => $this->isEdit ? 'nullable|image|max:1024' : 'required|image|max:1024',
        ];
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->course_name = '';
        $this->description = '';
        $this->image = null;
        $this->course_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();

        $imageKit = app(ImageKitService::class);
        $imageUrl = $imageKit->upload($this->image, '/courses');

        Course::create([
            'course_name' => $this->course_name,
            'description' => $this->description,
            'image' => $imageUrl,
        ]);

        $this->dispatch('toast', message: 'Course created successfully!', type: 'success');
        $this->closeModal();
        $this->loadCourses();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $id;
        $this->course_name = $course->course_name;
        $this->description = $course->description;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $course = Course::findOrFail($this->course_id);

        $data = [
            'course_name' => $this->course_name,
            'description' => $this->description,
        ];

        if ($this->image) {
            $imageKit = app(ImageKitService::class);
            $data['image'] = $imageKit->upload($this->image, '/courses');
        }

        $course->update($data);

        $this->dispatch('toast', message: 'Course updated successfully!', type: 'success');
        $this->closeModal();
        $this->loadCourses();
    }

    public function delete($id)
    {
        Course::findOrFail($id)->delete();
        $this->dispatch('toast', message: 'Course deleted successfully!', type: 'delete');
        $this->loadCourses();
    }

    public function render()
    {
        return view('livewire.admin.course-management');
    }
}
