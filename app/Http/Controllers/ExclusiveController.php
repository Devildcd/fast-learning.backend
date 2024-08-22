<?php

namespace App\Http\Controllers;

use App\Models\Exclusive;
use App\Models\ExclusiveDoc;
use App\Models\ExclusiveImage;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExclusiveController extends Controller
{
    public function index(Subject $subject)
    {
        $exclusives = $subject->exclusives;
        return response()->json($exclusives);
    }

    
    public function show(Exclusive $exclusive)
    {
        $exclusive->load('exclusiveImages', 'exclusiveDocs');
        return response()->json($exclusive ?: ['message' => 'Not found'], $exclusive ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(Exclusive::rules());
        $exclusive = Exclusive::create($validatedData);
        $fileTypes = [
            'exclusiveImages' => 'public/img',
            'exclusiveDocs' => 'public/doc',
        ];

        foreach ($fileTypes as $inputName => $storagePath) {
            if ($request->hasFile($inputName)) {
                foreach ($request->file($inputName) as $file) {
                    // Para imágenes, usar el almacenamiento con nombre generado automáticamente
                    if ($inputName === 'exclusiveImages') {
                        $filePath = $file->store($storagePath);
                    } else {
                        // Para documentos, usar el nombre original del archivo
                        $originalName = $file->getClientOriginalName();
                        $filePath = $file->storeAs($storagePath, $originalName);
                    }

                    $modelClass = $inputName === 'exclusiveImages'
                        ? ExclusiveImage::class
                        : ExclusiveDoc::class;

                    $modelClass::create([
                        'path' => $filePath, // Ruta completa relativa a 'public'
                        'exclusive_id' => $exclusive->id,
                    ]);
                }
            }
        }
        return response()->json($exclusive, 201);
    }

    
    public function update(Request $request, Exclusive $exclusive)
    {
        if (!$exclusive) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $exclusive->load('exclusiveImages', 'exclusiveDocs');
        $validatedData = $request->validate(Exclusive::rules());
        $exclusive->update($validatedData);

        return response()->json($exclusive);
    }

    
    public function destroy(Exclusive $exclusive)
    {
        if (!$exclusive) {
            return response()->json(['message' => 'Not found'], 404);
        }

        DB::transaction(function () use ($exclusive) {
            $imagePaths = $exclusive->exclusiveImages->pluck('path')->toArray();
            $docPaths = $exclusive->exclusiveDocs->pluck('path')->toArray();
    
            // Eliminar los archivos del almacenamiento
            Storage::delete(array_merge($imagePaths, $docPaths));
    
            $exclusive->exclusiveImages()->delete();
            $exclusive->exclusiveDocs()->delete();
    
            $exclusive->delete();
        });
        return response()->json(null, 204);
    }
}
