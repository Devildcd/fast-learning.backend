<?php

namespace App\Http\Controllers;

use App\Models\ContentLevel;
use Illuminate\Http\Request;

class ContentLevelController extends Controller
{
    public function index()
    {
        $levels = ContentLevel::all();
        return response()->json($levels);
    }

    
    public function show(ContentLevel $level)
    {
        return response()->json($level ?: ['message' => 'Not found'], $level ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(ContentLevel::rules());
        $level = ContentLevel::create($validatedData);
        return response()->json($level, 201);
    }

    
    public function update(Request $request, ContentLevel $level)
    {
        if (!$level) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validatedData = $request->validate(ContentLevel::rules());
        $level->update($validatedData);

        return response()->json($level);
    }

    
    public function destroy(ContentLevel $level)
    {
        if (!$level) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $level->delete();
        return response()->json(null, 204);
    }
}
