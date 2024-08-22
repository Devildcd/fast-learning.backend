<?php

namespace App\Http\Controllers;

use App\Models\MediaArchive;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaArchiveController extends Controller
{
    public function index(Subject $subject)
    {
        $archives = $subject->archives()->with('subject')->get();
        return response()->json($archives);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    if ($request->hasFile('path')) {
        $documentsData = [];
        foreach ($request->file('path') as $doc) {
            $originalName = $doc->getClientOriginalName();
            $destinationPath = 'public/doc';
            $docPath = $doc->storeAs($destinationPath, $originalName);
            $documentsData[] = [
                'path' => $docPath,
                'subject_id' => $request->subject_id,
            ];
        }
        // Insertar los datos en la base de datos en una sola operación
        if (!empty($documentsData)) {
            DB::table('media_archives')->insert($documentsData);
        }
    }
    return response()->json(['message' => 'Documents created'], 201);
    }

    public function destroy(MediaArchive $doc)
    {
        Storage::delete($doc->path);
        $doc->delete();

        return response()->json(null, 204);
    }
}
