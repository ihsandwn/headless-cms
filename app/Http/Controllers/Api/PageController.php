<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of published pages.
     * Eager loading 'user' for performance.
     */
    public function index()
    {
        $pages = Page::with('user')
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return PageResource::collection($pages);
    }

    /**
     * Display the specified page.
     * Route model binding by slug is handled in routes/api.php
     */
    public function show(Page $page)
    {
        if ($page->status !== 'published') {
            abort(404);
        }

        return new PageResource($page->load('user'));
    }
}