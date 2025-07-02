<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * Eager loading 'categories' and 'user' to prevent N+1 query problems, which is crucial for performance.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'categories'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');

        // Allow filtering by category slug
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Paginate results for performance and manageability
        $posts = $query->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     * The {post:slug} in api.php handles the model binding.
     */
    public function show(Post $post)
    {
        // Ensure only published posts are shown via the API
        if ($post->status !== 'published' || $post->published_at > now()) {
            abort(404);
        }

        // Load relationships for the single post view
        return new PostResource($post->load(['user', 'categories']));
    }
}