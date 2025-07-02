<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public $showModal = false;
    public $categoryId;
    public $name, $slug;

    public function create()
    {
        $this->resetInput();
        $this->showModal = true;
    }
    
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->showModal = true;
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }
    
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $this->categoryId,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->categoryId,
        ]);

        Category::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
            'slug' => $this->slug,
        ]);
        
        session()->flash('message', $this->categoryId ? 'Category Updated.' : 'Category Created.');
        $this->closeModal();
    }

    public function delete($id)
    {
        // For safety, you might check if a category is in use before deleting.
        $category = Category::withCount('posts')->findOrFail($id);
        if ($category->posts_count > 0) {
            session()->flash('error', 'Cannot delete category with associated posts.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Category Deleted.');
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->slug = '';
    }

    public function render()
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}