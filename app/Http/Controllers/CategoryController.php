<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
   
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    
    public function show(Category $category)
    {
        return response()->json($category ?: ['message' => 'Not found'], $category ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(Category::rules());
        $category = Category::create($validatedData);
        return response()->json($category, 201);
    }

    
    public function update(Request $request, Category $category)
    {
        if (!$category) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validatedData = $request->validate(Category::rules());
        $category->update($validatedData);

        return response()->json($category);
    }

    
    public function destroy(Category $category)
    {
        if (!$category) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $category->delete();
        return response()->json(null, 204);
    }
}
