<?php

namespace App\Livewire\User;

use App\Models\Event;
use App\Models\EventParticipant;
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

    // VIEW MODAL
    public $showViewModal = false;
    public $viewTitle;
    public $viewDescription;
    public $viewEventDate;
    public $viewLocation;
    public $viewOrganizer;

    // for edit
    public $showEditModal = false;
    public $eventId;
    // public $viewEventId;

    // open edit form and pre-fill
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== Auth::id()) {
            return;
        }

        // store id for updateEvent()
        $this->eventId = $event->id;

        // pre-fill form fields
        $this->title       = $event->title;
        $this->description = $event->description;
        // format for datetime-local input
        $this->event_date  = $event->event_date?->format('Y-m-d\TH:i');
        $this->location    = $event->location;

        $this->showEditModal = true;
    }

    // update event
    public function updateEvent()
    {
        $this->validate();

        $event = Event::findOrFail($this->eventId);

        if ($event->user_id !== Auth::id()) {
            return;
        }

        $event->update([
            'title'       => $this->title,
            'description' => $this->description,
            'event_date'  => $this->event_date,
            'location'    => $this->location,
        ]);

        $this->showEditModal = false;

        $this->reset(['eventId', 'title', 'description', 'event_date', 'location']);

        session()->flash('message', 'Event updated successfully!');
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['eventId', 'title', 'description', 'event_date', 'location']);
    }

    public function toggleCreate()
    {
        $this->isCreating = ! $this->isCreating;
        $this->resetValidation();
        if (!$this->isCreating) {
            $this->reset(['title', 'description', 'event_date', 'location']);
        }
    }

    // create event
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
        if ($event && $event->user_id == Auth::id()) {
            $event->delete();
        }
    }

    // VIEW MODAL
    public $viewEventId;
    public $viewOwnerId;
    public function view($id)
    {
        $event = Event::with('user')->findOrFail($id);

        $this->viewEventId = $event->id;
        $this->viewOwnerId = $event->user_id;

        $this->viewTitle       = $event->title;
        $this->viewDescription = $event->description;
        $this->viewEventDate   = $event->event_date;
        $this->viewLocation    = $event->location;
        $this->viewOrganizer   = $event->user->first_name . ' ' . $event->user->last_name ?? 'Unknown';

        $this->showViewModal   = true;
    }

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

    // request to join event
    // public function joinEvent($id){
    //     if (Event::find($id)->participants()->where('user_id', Auth::id())->exists()) {
    //         return;
    //     }
    //     $event = Event::findOrFail($id);
    //     $event->participants()->create([
    //         'user_id' => Auth::id(),
    //         'status'  => 'pending',
    //     ]);
    // }

    // event participate button component will handle join/cancel logic
    // public function mount($event = null){
    //     // no specific mount logic for now

    //     if ($event) {
    //         // for possible future use

    //     }

    // }

    // organizer: accept participation request
    public function acceptParticipationRequest($participantId)
    {
        $participant = EventParticipant::with('event')->findOrFail($participantId);

        if ($participant->event->user_id !== Auth::id()) {
            return;
        }

        $participant->update([
            'status' => 'approved',
        ]);
    }

    // organizer: reject participation request
    public function rejectParticipationRequest($participantId)
    {
        $participant = EventParticipant::with('event')->findOrFail($participantId);

        if ($participant->event->user_id !== Auth::id()) {
            return;
        }

        $participant->update([
            'status' => 'rejected',
        ]);
    }

    // participants list for organizer view modal
    public $participantListModal = false;
    public $participantEventId;
    public function participantsList($id)
    {
        $event = Event::with('participants.user')->findOrFail($id);
        if ($event->user_id !== Auth::id()) {
            return;
        }
        $this->participantEventId = $event->id;
        $this->participantListModal = true;
    }


    // public function render(){
    //     return view('livewire.user.event-live', [
    //         'events' => Event::with('user')->orderBy('event_date', 'asc')->get(),
    //         'participants' => EventParticipant::with('user')->get(),
    //     ]);
    // }

    public function render()
    {
        $participants = collect(); // empty by default

        if ($this->participantEventId) {
            $participants = EventParticipant::with('user')
                ->where('event_id', $this->participantEventId)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.user.event-live', [
            'events'       => Event::with('user')->orderBy('event_date', 'asc')->get(),
            'participants' => $participants,
        ]);
    }
}
