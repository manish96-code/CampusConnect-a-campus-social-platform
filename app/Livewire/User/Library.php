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

    public function create()
    {
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

    public function delete($id)
    {
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
    public function view($id)
    {
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

    public $search = "";
    // filter
    public $filter = 'all';
    public function setFilter($filter)
    {
        $allowed = ['all', 'mine'];
        if (! in_array($filter, $allowed)) {
            $filter = 'all';
        }
        $this->filter = $filter;
        // $this->search = '';
        $this->reset('search');
    }


    public function render()
    {
        $query = LibraryModel::with('user')->latest();

        if ($this->filter === 'mine') {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                // not logged in => nothing
                $query->whereRaw('0 = 1');
            }
        }

        if (!empty(trim($this->search))) {
            $term = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhereHas('user', function ($u) use ($term) {
                        $u->where('first_name', 'like', $term)
                            ->orWhere('last_name', 'like', $term);
                    });
            });
        }


        $documents = $query->get();

        return view('livewire.user.library', [
            'documents' => $documents
        ]);
    }
}
