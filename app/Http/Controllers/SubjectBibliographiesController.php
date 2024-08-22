<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectBibliographies;
use Illuminate\Http\Request;

class SubjectBibliographiesController extends Controller
{
    public function index(Subject $subject)
    {
        $bibliographies = $subject->bibliographies;
        return response()->json($bibliographies);
    }

    
    public function show(SubjectBibliographies $bibliography)
    {
        return response()->json($bibliography ?: ['message' => 'Not found'], $bibliography ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(SubjectBibliographies::rules());
        $bibliography = SubjectBibliographies::create($validatedData);
        return response()->json($bibliography, 201);
    }

    
    public function update(Request $request, SubjectBibliographies $bibliography)
    {
        if (!$bibliography) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validatedData = $request->validate(SubjectBibliographies::rules());
        $bibliography->update($validatedData);

        return response()->json($bibliography);
    }

    
    public function destroy(SubjectBibliographies $bibliography)
    {
        if (!$bibliography) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $bibliography->delete();
        return response()->json(null, 204);
    }
}
