<?php

namespace App\Livewire\User;

use Livewire\Component;

class EventParticipateButton extends Component{

    public $event;
    public $participationStatus;

    public function mount($event){
        $this->event = $event;
        $this->determineParticipationStatus();
    }

    public function determineParticipationStatus(){
        $user = auth()->user();

        $participantRecord = $this->event->participants()->where('user_id', $user->id)->first();

        if(!$participantRecord){
            $this->participationStatus = 'not_participating';
        }
        elseif($participantRecord->status == 'pending'){
            $this->participationStatus = 'pending';
        }
        elseif($participantRecord->status == 'approved'){
            $this->participationStatus = 'participating';
        }
        else{
            $this->participationStatus = 'not_participating';
        }
    }

    public function render(){
        return view('livewire.user.event-participate-button');
    }
}
