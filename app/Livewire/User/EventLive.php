<?php

namespace App\Livewire\User;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.user')]
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
        $this->title = $event->title;
        $this->description = $event->description;
        // format for datetime-local input
        $this->event_date = $event->event_date?->format('Y-m-d\TH:i');
        $this->location = $event->location;

        $this->showEditModal = true;
    }

    // update event
    public function updateEvent()
    {
        $this->validate();
        $event = Event::findOrFail($this->eventId);

        if ($event->user_id !== Auth::id()) {
            $this->dispatch('toast', message: 'Unauthorized action!', type: 'error');

            return;
        }

        $event->update([
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'location' => $this->location,
        ]);

        $this->showEditModal = false;

        $this->reset(['eventId', 'title', 'description', 'event_date', 'location']);

        $this->dispatch('toast', message: 'Event details updated.', type: 'success');
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
        if (! $this->isCreating) {
            $this->reset(['title', 'description', 'event_date', 'location']);
        }
    }

    // create event
    public function createEvent()
    {
        $this->validate();

        Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'location' => $this->location,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['title', 'description', 'event_date', 'location']);
        $this->isCreating = false;

        $this->dispatch('toast',
            message: 'Campus Event created successfully! 🗓️',
            type: 'success'
        );
    }

    public function delete($id)
    {
        $event = Event::find($id);
        if ($event && $event->user_id == Auth::id()) {
            $event->delete();
            $this->dispatch('toast', message: 'Event has been cancelled.', type: 'delete');
        } else {
            $this->dispatch('toast', message: 'You cannot delete this event.', type: 'error');
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

        $this->viewTitle = $event->title;
        $this->viewDescription = $event->description;
        $this->viewEventDate = $event->event_date;
        $this->viewLocation = $event->location;
        $this->viewOrganizer = $event->user->first_name.' '.$event->user->last_name ?? 'Unknown';

        $this->showViewModal = true;
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

    // organizer: accept participation request
    public function acceptParticipationRequest($participantId)
    {
        $participant = EventParticipant::with('event')->findOrFail($participantId);

        if ($participant->event->user_id !== Auth::id()) {
            $this->dispatch('toast', message: 'Permission denied.', type: 'error');

            return;
        }

        $participant->update([
            'status' => 'approved',
        ]);

        $this->dispatch('toast',
            message: "Student approved for {$participant->event->title} ✅",
            type: 'success'
        );
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

        $this->dispatch('toast', message: 'Participation request rejected.', type: 'delete');
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

    public $filter = 'upcoming';

    public function setFilter($filter)
    {
        $allowed = ['all', 'upcoming', 'past', 'mine'];
        if (! in_array($filter, $allowed)) {
            $filter = 'upcoming';
        }
        $this->filter = $filter;
    }

    public function render()
    {

        $query = Event::with('user')->orderBy('event_date', 'asc');
        $now = now();

        if ($this->filter === 'upcoming') {
            $query->where('event_date', '>=', $now);
        } elseif ($this->filter === 'past') {
            $query->where('event_date', '<', $now);
        } elseif ($this->filter === 'mine') {
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            } else {
                $query->whereRaw('0 = 1');
            }
        }
        $events = $query->get();

        $participants = collect();

        if ($this->participantEventId) {
            $participants = EventParticipant::with('user')
                ->where('event_id', $this->participantEventId)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.user.event-live', [
            'events' => $events,
            'participants' => $participants,
        ]);
    }
}
