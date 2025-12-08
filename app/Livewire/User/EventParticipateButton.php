<?php

namespace App\Livewire\User;

use App\Models\Event;
use Livewire\Component;

class EventParticipateButton extends Component
{
    public $event;
    public $eventId;
    public $participationStatus;

    public function mount($eventId)
    {
        $this->eventId = $eventId;
        $this->event = Event::findOrFail($eventId);
        $this->determineParticipationStatus();
    }

    public function determineParticipationStatus()
    {
        $user = auth()->user();

        if (! $user) {
            $this->participationStatus = 'not_participating';
            return;
        }

        $participantRecord = $this->event->participants()
            ->where('user_id', $user->id)
            ->first();

        if (! $participantRecord) {
            $this->participationStatus = 'not_participating';
        } elseif ($participantRecord->status === 'pending') {
            $this->participationStatus = 'request_sent';
        } elseif ($participantRecord->status === 'approved') {
            $this->participationStatus = 'participating';
        } else {
            $this->participationStatus = 'not_participating';
        }
    }

    public function sendParticipationRequest()
    {
        $user = auth()->user();
        if (! $user) return;

        $this->event->participants()->updateOrCreate(
            ['user_id' => $user->id],
            ['status'  => 'pending'],
        );

        $this->determineParticipationStatus();
    }

    public function cancelParticipationRequest()
    {
        $user = auth()->user();
        if (! $user) return;

        $this->event->participants()
            ->where('user_id', $user->id)
            ->delete();

        $this->determineParticipationStatus();
    }

    public function acceptParticipationRequest($userId)
    {
        if (auth()->id() !== $this->event->user_id) {
            return;
        }
        $this->event->participants()
            ->where('user_id', $userId)
            ->update(['status' => 'approved']);
    }

    public function rejectParticipationRequest($userId)
    {
        if (auth()->id() !== $this->event->user_id) {
            return;
        }
        $this->event->participants()
            ->where('user_id', $userId)
            ->delete();
    }

    public function render()
    {
        return view('livewire.user.event-participate-button');
    }
}
