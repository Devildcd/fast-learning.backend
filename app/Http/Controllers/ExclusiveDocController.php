<?php

namespace App\Http\Controllers;

use App\Models\ExclusiveDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExclusiveDocController extends Controller
{
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
                'exclusive_id' => $request->exclusive_id,
            ];
        }
        // Insertar los datos en la base de datos en una sola operación
        if (!empty($documentsData)) {
            DB::table('exclusive_docs')->insert($documentsData);
        }
    }
    return response()->json(['message' => 'Documents created'], 201);
    }

    public function destroy(ExclusiveDoc $doc)
    {
        Storage::delete($doc->path);
        $doc->delete();

        return response()->json(null, 204);
    }
}
