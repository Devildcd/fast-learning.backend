<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Http\Request;


class ContentTypeController extends Controller
{
    public function index()
    {
        $types = ContentType::all();
        return response()->json($types);
    }

    
    public function show(ContentType $type)
    {
        return response()->json($type ?: ['message' => 'Not found'], $type ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(ContentType::rules());
        $type = ContentType::create($validatedData);
        return response()->json($type, 201);
    }

    
    public function update(Request $request, ContentType $type)
    {
        if (!$type) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validatedData = $request->validate(ContentType::rules());
        $type->update($validatedData);

        return response()->json($type);
    }

    
    public function destroy(ContentType $type)
    {
        if (!$type) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $type->delete();
        return response()->json(null, 204);
    }
}
