<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectPhoto;
use Illuminate\Support\Facades\Storage;

class SubjectPhotoController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate(SubjectPhoto::rules());
        if ($request->hasFile('urlPhoto')) {
            $path = $request->file('urlPhoto')->store('public/img');
            $photo = SubjectPhoto::create([
                'subject_id' => $validatedData['subject_id'],
                'urlPhoto' => $path
            ]);

            return response()->json($photo, 201);
        }
    }
    

    public function destroy(SubjectPhoto $photo)
    {
        if (!$photo) {
            return response()->json(['message' => 'Not found'], 404);
        }
        Storage::delete($photo->urlPhoto);
        $photo->delete();

        return response()->json([201]);
    }

}
