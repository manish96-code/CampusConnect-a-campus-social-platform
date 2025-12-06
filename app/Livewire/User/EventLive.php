<?php

namespace App\Livewire\User;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout("components.layouts.user")]
class EventLive extends Component
{
    #[Validate('required|string|max:200')]
    public $title;

    #[Validate('nullable|string|max:1000')]
    public $description;

    #[Validate('required|date')]
    public $event_date;

    #[Validate('required|string|max:255')]
    public $location;

    public $isCreating = false;

    public $showViewModal = false;
    public $viewTitle;
    public $viewDescription;
    public $viewEventDate;
    public $viewLocation;
    public $viewOrganizer;

    public function toggleCreate()
    {
        $this->isCreating = ! $this->isCreating;
        $this->resetValidation();
        if(!$this->isCreating) {
            $this->reset(['title', 'description', 'event_date', 'location']);
        }
    }

    public function createEvent()
    {
        $this->validate();

        Event::create([
            'title'       => $this->title,
            'description' => $this->description,
            'event_date'  => $this->event_date,
            'location'    => $this->location,
            'user_id'     => Auth::id(),
        ]);

        $this->reset(['title', 'description', 'event_date', 'location']);
        $this->isCreating = false;

        session()->flash('message', 'Event created successfully!');
    }

    public function delete($id)
    {
        $event = Event::find($id);
        if($event && $event->user_id == Auth::id()){
            $event->delete();
        }
    }

    //  view modal
    public function view($id)
    {
        $event = Event::with('user')->findOrFail($id);

        $this->viewTitle       = $event->title;
        $this->viewDescription = $event->description;
        $this->viewEventDate   = $event->event_date;
        $this->viewLocation    = $event->location;
        $this->viewOrganizer   = $event->user->first_name ?? 'Unknown';

        $this->showViewModal   = true;
    }

    //  close view modal
    public function closeViewModal()
    {
        $this->reset([
            'showViewModal',
            'viewTitle',
            'viewDescription',
            'viewEventDate',
            'viewLocation',
            'viewOrganizer',
        ]);
    }

    public function render()
    {
        return view('livewire.user.event-live', [
            'events' => Event::with('user')->orderBy('event_date', 'asc')->get(),
        ]);
    }
}
