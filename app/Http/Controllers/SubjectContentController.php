<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectContent;
use App\Models\SubjectContentDoc;
use App\Models\SubjectContentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubjectContentController extends Controller
{
    public function index(Subject $subject)
    {
        $contents = $subject->contents()->with('subject')->get();
        return response()->json($contents);
    }

    public function show(SubjectContent $content)
    {
        $content->load('subjectContentImages', 'subjectContentDocs');
        return response()->json($content ?: ['message' => 'Not found'], $content ? 200 : 404);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate(SubjectContent::rules());
        $content = SubjectContent::create($validatedData);
        $fileTypes = [
            'subjectContentImages' => 'public/img',
            'subjectContentDocs' => 'public/doc',
        ];

        foreach ($fileTypes as $inputName => $storagePath) {
            if ($request->hasFile($inputName)) {
                foreach ($request->file($inputName) as $file) {
                    // Para imágenes, usar el almacenamiento con nombre generado automáticamente
                    if ($inputName === 'subjectContentImages') {
                        $filePath = $file->store($storagePath);
                    } else {
                        // Para documentos, usar el nombre original del archivo
                        $originalName = $file->getClientOriginalName();
                        $filePath = $file->storeAs($storagePath, $originalName);
                    }

                    $modelClass = $inputName === 'subjectContentImages'
                        ? SubjectContentImage::class
                        : SubjectContentDoc::class;

                    $modelClass::create([
                        'path' => $filePath, // Ruta completa relativa a 'public'
                        'subject_content_id' => $content->id,
                    ]);
                }
            }
        }
        return response()->json($content, 201);
    }


    public function update(Request $request, SubjectContent $content)
    {
        if (!$content) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $content->load('subjectContentImages', 'subjectContentDocs');
        $validatedData = $request->validate(SubjectContent::rules());
        $content->update($validatedData);

        return response()->json($content);
    }


    public function destroy(SubjectContent $content)
    {
        if (!$content) {
            return response()->json(['message' => 'Not found'], 404);
        }

        DB::transaction(function () use ($content) {
            $imagePaths = $content->subjectContentImages->pluck('path')->toArray();
            $docPaths = $content->subjectContentDocs->pluck('path')->toArray();
    
            // Eliminar los archivos del almacenamiento
            Storage::delete(array_merge($imagePaths, $docPaths));
    
            $content->subjectContentImages()->delete();
            $content->subjectContentDocs()->delete();
    
            $content->delete();
        });
        return response()->json(null, 204);
    }

    public function contentsFilter(Request $request)
    {
        $levelId = $request->query('content_levels');
        $typeId = $request->query('content_types');
        $subjectId = $request->query('subjects');
        $query = SubjectContent::query();

        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }
        if ($levelId) {
            $query->where('content_level_id', $levelId);
        }
        if ($typeId) {
            $query->where('content_type_id', $typeId);
        }

        $contents = $query->get();
        return response()->json($contents);
    }
}
