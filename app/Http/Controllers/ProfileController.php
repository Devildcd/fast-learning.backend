<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('category')->get();
        return response()->json($profiles);
    }

    
    public function show(Profile $profile)
    {
        $profile->load('category');
        return response()->json($profile ?: ['message' => 'Not found'], $profile ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(Profile::rules());
        $profile = Profile::create($validatedData);
        return response()->json($profile, 201);
    }

    
    public function update(Request $request, Profile $profile)
    {
        if (!$profile) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $profile->load('category');
        $validatedData = $request->validate(Profile::rules());
        $profile->update($validatedData);

        return response()->json($profile);
    }

    
    public function destroy(Profile $profile)
    {
        if (!$profile) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $profile->delete();
        return response()->json(null, 204);
    }

    public function profilesFilter(Request $request)
    {
        $categoryId = $request->query('categories');
        $query = Profile::query();
    
        // Filtrar por Category a través de Profile y Specialization
        if ($categoryId) {
            $query->whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        }
    
        $profiles = $query->get();
        return response()->json($profiles);
    }
}
