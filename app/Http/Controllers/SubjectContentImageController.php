<?php

namespace App\Http\Controllers;

use App\Models\SubjectContent;
use App\Models\SubjectContentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class SubjectContentImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('path')) {
            $imagesData = [];
            foreach ($request->file('path') as $image) {
                $uniqueName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = 'public/img';
                $imagePath = $image->storeAs($destinationPath, $uniqueName);
                $imagesData[] = [
                    'path' => $imagePath,
                    'subject_content_id' => $request->subject_content_id,
                ];
            }
            if (!empty($imagesData)) {
                DB::table('subject_content_images')->insert($imagesData);
            }
        }
        return response()->json(['message' => 'Images created'], 201);
    }

    public function destroy(SubjectContentImage $image)
    {
        Storage::delete($image->path);
        $image->delete();

        return response()->json(null, 204);
    }

    public function deleteAllImages(SubjectContent $content)
    {
        $images = $content->subjectContentImages;
        foreach ($images as $image) {
            Storage::delete($image->path);
            $image->delete();
        }
        return response()->json(null, 204);
    }
}
