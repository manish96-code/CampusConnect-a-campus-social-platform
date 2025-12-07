<?php

namespace App\Livewire\User;

use App\Models\Library as LibraryModel; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]
class Library extends Component 
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('required|file|max:10240')]
    public $file;

    public $isCreating = false;

    // Viewer state
    public $showViewer = false;
    public $viewerUrl;
    public $viewerTitle;
    public $viewerExt;

    public function toggleCreate()
    {
        $this->isCreating = ! $this->isCreating;
        $this->resetValidation();
        $this->reset(['title', 'file']);
    }

    public function create(){
        $this->validate();

        $path = $this->file->store('library_docs', 'public');

        LibraryModel::create([
            'user_id' => Auth::id(),
            'title'   => $this->title,
            'file'    => $path,
        ]);

        $this->reset(['title', 'file']);
        $this->isCreating = false;
        
        session()->flash('message', 'Document uploaded successfully!');
    }

    public function delete($id){
        $doc = LibraryModel::find($id);
        
        if ($doc && $doc->user_id === Auth::id()) {
            if ($doc->file) {
                Storage::disk('public')->delete($doc->file);
            }
            $doc->delete();
            session()->flash('message', 'Document deleted.');
        }
    }

    //  Open viewer
    public function view($id){
        $doc = LibraryModel::with('user')->findOrFail($id);

        $this->viewerUrl   = Storage::url($doc->file);
        $this->viewerTitle = $doc->title;
        $this->viewerExt   = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION));

        $this->showViewer = true;
    }

    //  Close viewer
    public function closeViewer()
    {
        $this->reset(['showViewer', 'viewerUrl', 'viewerTitle', 'viewerExt']);
    }

    public function render()
    {
        $documents = LibraryModel::with('user')->latest()->get();

        return view('livewire.user.library', [ 
            'documents' => $documents
        ]);
    }
}
