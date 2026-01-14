<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use App\Models\GroupPost;
use App\Services\ImageKitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]

class Profile extends Component{

    use WithFileUploads;

    public $group;
    public $activeTab = 'discussion';
    public $isAdmin = false;
    public $media = [];
    public $allAdmins;

    public string $group_name = '';
    public ?string $description = null;
    public string $group_type = 'public';


    #[Validate('nullable|image|max:2048')]
    public $profile_pic;

    #[Validate('nullable|image|max:4096')]
    public $cover_pic;

    public function mount($id){
        $this->group = Group::with(['members', 'creator'])->findOrFail($id);

        $this->isAdmin = $this->group->members()
            ->where('users.id', auth()->id())
            ->wherePivot('role', 'admin')
            ->wherePivot('status', 'approved')
            ->exists();

        $this->group_name = $this->group->group_name;
        $this->description = $this->group->description;
        $this->group_type = $this->group->group_type;

        $this->media = GroupPost::where('group_id', $this->group->id)
            ->whereNotNull('image')
            ->latest()
            ->get();

            $owner = $this->group->creator;
            $otherAdmins = $this->group->members()
                ->wherePivot('role', 'admin')
                ->wherePivot('status', 'approved')
                ->get();

        $this->allAdmins = collect([$owner])->merge($otherAdmins)->unique('id');
    }


    public function updatedProfilePic(){
        $this->updateGroupImages();
    }

    public function updatedCoverPic(){
        $this->updateGroupImages();
    }

    public function updateGroupImages(){
        if (!$this->isAdmin) return;

        $this->validate([
            'profile_pic' => 'nullable|image|max:2048',
            'cover_pic' => 'nullable|image|max:4096',
        ]);

        $imageKit = app(ImageKitService::class);

        if ($this->profile_pic) {
            $path = $imageKit->upload($this->profile_pic, 'groups/profile');
            $this->group->profile_pic = $path;
            $this->reset('profile_pic');
        }

        if ($this->cover_pic) {
            $path = $imageKit->upload($this->cover_pic, 'groups/cover');
            $this->group->cover_pic = $path;
            $this->reset('cover_pic');
        }

        $this->group->save();
        
        $this->group->refresh();

        session()->flash('message', 'Images updated successfully! 🖼️');
    }

    public function setTab($tab){
        $this->activeTab = $tab;
    }


    public function saveGroup(){
        if (! $this->isAdmin) return;

        $this->validate([
            'group_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('groups', 'group_name')->ignore($this->group->id),
            ],
            'description' => 'nullable|string|max:500',
            'group_type'  => 'required|in:public,private',
        ]);

        $this->group->update([
            'group_name' => $this->group_name,
            'description' => $this->description,
            'group_type' => $this->group_type,
        ]);

        session()->flash('message', 'Group updated successfully ✅');
        $this->activeTab = 'discussion';
    }


    public function render(){
        return view('livewire.user.group.profile');
    }
}
