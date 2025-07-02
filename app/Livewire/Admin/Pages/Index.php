<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public $showModal = false;
    public $pageId;
    public $title, $slug, $body, $status;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string', // uniqueness checked in store()
        'body' => 'required',
        'status' => 'required|in:draft,published',
    ];

    public function create()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $this->pageId = $id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->body = $page->body;
        $this->status = $page->status;
        $this->showModal = true;
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function store()
    {
        $this->validate([
            'slug' => 'required|string|unique:pages,slug,' . $this->pageId
        ] + $this->rules);


        Page::updateOrCreate(['id' => $this->pageId], [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'status' => $this->status,
        ]);

        session()->flash('message', $this->pageId ? 'Page Updated.' : 'Page Created.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Page::findOrFail($id)->delete();
        session()->flash('message', 'Page Deleted.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInput();
    }
    
    private function resetInput()
    {
        $this->pageId = null;
        $this->title = '';
        $this->slug = '';
        $this->body = '';
        $this->status = 'draft';
    }

    public function render()
    {
        return view('livewire.admin.pages.index', [
            'pages' => Page::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}