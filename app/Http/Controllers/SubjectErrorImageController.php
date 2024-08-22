<?php

namespace App\Http\Controllers;

use App\Models\SubjectErrorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectErrorImageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate(SubjectErrorImage::rules());
        if ($request->hasFile('urlImage')) {
            $path = $request->file('urlImage')->store('public/img');
            $image = SubjectErrorImage::create([
                'error_id' => $validatedData['error_id'],
                'urlImage' => $path
            ]);

            return response()->json($image, 201);
        }
    }
    

    public function destroy(SubjectErrorImage $image)
    {
        if (!$image) {
            return response()->json(['message' => 'Not found'], 404);
        }
        Storage::delete($image->urlImage);
        $image->delete();

        return response()->json([201]);
    }
}
