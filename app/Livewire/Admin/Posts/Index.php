<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showModal = false;
    public $postId;
    public $title, $slug, $content, $excerpt, $status, $image, $newImage;

    public function create()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;
        $this->excerpt = $post->excerpt;
        $this->status = $post->status;
        $this->image = $post->image;
        $this->newImage = null; // Reset file input
        $this->showModal = true;
    }
    
    // Real-time slug generation for better UX
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,' . $this->postId,
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'newImage' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $imageUrl = $this->image;
        if ($this->newImage) {
            // For performance, run image optimization here before storing.
            // A library like spatie/laravel-image-optimizer is recommended.
            $imageUrl = $this->newImage->store('posts', 'public');
        }

        Post::updateOrCreate(['id' => $this->postId], [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'image' => $imageUrl,
            'published_at' => $this->status === 'published' ? now() : null,
        ]);

        session()->flash('message', $this->postId ? 'Post Updated Successfully.' : 'Post Created Successfully.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInput();
    }
    
    private function resetInput()
    {
        $this->postId = null;
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->excerpt = '';
        $this->status = 'draft';
        $this->image = null;
        $this->newImage = null;
    }

    public function render()
    {
        // Eager loading categories to prevent N+1 issues in the view.
        $posts = Post::with('categories')->latest()->paginate(10);
        return view('livewire.admin.posts.index', ['posts' => $posts])
            ->layout('layouts.app'); // Assumes Jetstream layout
    }
}