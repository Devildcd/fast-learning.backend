<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('photo')->get();
        return response()->json($subjects);
    }

    
    public function show(Subject $subject)
    {
        $subject->load('photo');
        return response()->json($subject ?: ['message' => 'Not found'], $subject ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(Subject::rules());
        $subject = Subject::create($validatedData);
        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/img');
                SubjectPhoto::create([
                    'subject_id' => $subject->id,
                    'urlPhoto' => $path
                ]);
        }

        return response()->json($subject, 201);
    }

    
    public function update(Request $request, Subject $subject)
    {
        if (!$subject) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validatedData = $request->validate(Subject::rules());
        $subject->update($validatedData);

        return response()->json($subject);
    }

    
    public function destroy(Subject $subject)
    {
        if (!$subject) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $photo = $subject->photo;
        if($photo) {
            Storage::delete($photo->urlPhoto);
            $photo->delete();    
        }

        $subject->delete();
        return response()->json(null, 204);
    }

    public function subjectsFilter(Request $request)
    {
        $categoryId = $request->query('categories');
        $profileId = $request->query('profiles');
        $specializationId = $request->query('specializations');
        $query = Subject::query();
    
        // Filtrar por Category a través de Profile y Specialization
        if ($categoryId) {
            $query->whereHas('specialization.profile.category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        }
    
        // Filtrar por Profile a través de Specialization
        if ($profileId) {
            $query->whereHas('specialization.profile', function ($query) use ($profileId) {
                $query->where('id', $profileId);
            });
        }
    
        // Filtrar por Specialization directamente
        if ($specializationId) {
            $query->whereHas('specialization', function ($query) use ($specializationId) {
                $query->where('id', $specializationId);
            });
        }
    
        $materias = $query->get();
        return response()->json($materias);
    }
}
