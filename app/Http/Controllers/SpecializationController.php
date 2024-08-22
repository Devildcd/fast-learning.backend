<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::with('profile')->get();
        return response()->json($specializations);
    }

    
    public function show(Specialization $specialization)
    {
        $specialization->load('profile');
        return response()->json($specialization ?: ['message' => 'Not found'], $specialization ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(Specialization::rules());
        $specialization = Specialization::create($validatedData);
        return response()->json($specialization, 201);
    }

    
    public function update(Request $request, Specialization $specialization)
    {
        if (!$specialization) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $specialization->load('profile');
        $validatedData = $request->validate(Specialization::rules());
        $specialization->update($validatedData);

        return response()->json($specialization);
    }

    
    public function destroy(Specialization $specialization)
    {
        if (!$specialization) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $specialization->delete();
        return response()->json(null, 204);
    }

    public function specializationsFilter(Request $request)
    {
        $categoryId = $request->query('categories');
        $profileId = $request->query('profiles');
        $query = Specialization::query();
    
        // Filtrar por Category a través de Profile y Specialization
        if ($categoryId) {
            $query->whereHas('profile.category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        }
    
        // Filtrar por Profile a través de Specialization
        if ($profileId) {
            $query->whereHas('profile', function ($query) use ($profileId) {
                $query->where('id', $profileId);
            });
        }
    
        $specializations = $query->get();
        return response()->json($specializations);
    }
}
