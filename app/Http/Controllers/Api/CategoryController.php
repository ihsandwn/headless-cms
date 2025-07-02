<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        // Using 'all()' is fine here as the number of categories is usually small.
        // For larger sets, pagination would be better.
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified category.
     * Route model binding by slug.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}