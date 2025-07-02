<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Posts\Index as PostsIndex;
use App\Livewire\Admin\Pages\Index as PagesIndex;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;

Route::get('/', function () {
    return redirect()->route('login');
});

// Admin / Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is_admin',
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/posts', PostsIndex::class)->name('posts.index');
    Route::get('/pages', PagesIndex::class)->name('pages.index');
    Route::get('/categories', CategoriesIndex::class)->name('categories.index');
});
