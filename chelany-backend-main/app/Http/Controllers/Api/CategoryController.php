<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Category::all(),
        ]);
    }

    // Store new category
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $category,
        ], 201);
    }

    // Show single category
    public function show(Category $category)
    {
        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    // Update category
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted',
        ]);
    }
}
