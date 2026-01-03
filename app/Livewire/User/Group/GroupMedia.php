<?php

namespace App\Livewire\User\Group;

use Livewire\Component;

class GroupMedia extends Component
{
    public $media;
    public $limit = null;

    public function render()
    {
        return view('livewire.user.group.group-media');
    }
}
