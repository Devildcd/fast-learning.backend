<?php

namespace App\Http\Controllers;

use App\Models\Exclusive;
use App\Models\ExclusiveImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExclusiveImageController extends Controller
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
                    'exclusive_id' => $request->exclusive_id,
                ];
            }
            if (!empty($imagesData)) {
                DB::table('exclusive_images')->insert($imagesData);
            }
        }
        return response()->json(['message' => 'Images created'], 201);
    }

    public function destroy(ExclusiveImage $image)
    {
        Storage::delete($image->path);
        $image->delete();

        return response()->json(null, 204);
    }

    public function deleteAllImages(Exclusive $exclusive)
    {
        $images = $exclusive->exclusiveImages;
        foreach ($images as $image) {
            Storage::delete($image->path);
            $image->delete();
        }
        return response()->json(null, 204);
    }
}
