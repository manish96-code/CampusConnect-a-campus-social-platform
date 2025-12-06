<?php

namespace App\Livewire\User;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout("components.layouts.user")]
class EventLive extends Component
{
    #[Validate('required|string|max:200')]
    public $title;

    #[Validate('nullable|string')]
    public $description;

    #[Validate('required|date')]
    public $event_date;

    #[Validate('nullable|string|max:255')]
    public $location;

    public function createEvent()
    {
        $this->validate();

        Event::create([
            'title'       => $this->title,
            'description' => $this->description,
            'event_date'  => $this->event_date,
            'location'    => $this->location,
            'user_id'     => auth()->id(),
        ]);

        $this->reset(['title', 'description', 'event_date', 'location']);

        session()->flash('success', 'Event created successfully!');
    }

    public function render()
    {
        return view('livewire.user.event-live', [
            'events' => Event::orderBy('event_date', 'desc')->get(),
        ]);
    }
}
