<?php

namespace App\Http\Controllers;

use App\Models\SubjectContentMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SubjectContentMediaController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'files' => 'required|array',
        'files.*' => 'file|max:2048',
        'subject_content_id' => 'required|exists:subject_contents,id',
    ]);

    // Debugging: Verifica que el ID se está recibiendo correctamente
    Log::info('Content ID recibido: ' . $request->subject_content_id);

    foreach ($request->file('files') as $file) {
        $type = $this->determineFileType($file);
        $path = $this->storeFile($file, $type);

        // Debugging: Verifica que se está intentando crear la entrada con el ID correcto
        Log::info('Creando entrada con Subject Content ID: ' . $request->subject_content_id);

        SubjectContentMedia::create([
            'path' => $path,
            'type' => $type,
            'subject_content_id' => $request->subject_content_id,
        ]);
    }

    return response()->json(['message' => 'Created'], 201);
}
}
