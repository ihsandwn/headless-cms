<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;

class Dashboard extends Component
{
    public $postCount;
    public $pageCount;
    public $categoryCount;

    /**
     * The mount method is called only once when the component is first instantiated.
     * This is efficient for loading initial data.
     */
    public function mount()
    {
        // Using count() is highly optimized for performance.
        $this->postCount = Post::count();
        $this->pageCount = Page::count();
        $this->categoryCount = Category::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app'); // Assumes Jetstream default layout
    }
}