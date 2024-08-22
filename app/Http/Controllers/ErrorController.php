<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\Subject;
use App\Models\SubjectErrorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ErrorController extends Controller
{
    public function index(Subject $subject)
    {
        $errors = $subject->errors;
        return response()->json($errors);
    }

    
    public function show(Error $error)
    {
        $error->load('errorImage');
        return response()->json($error ?: ['message' => 'Not found'], $error ? 200 : 404);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate(Error::rules());
        $error = Error::create($validatedData);
        if($request->hasFile('errorImage')) {
            $path = $request->file('errorImage')->store('public/img');
                SubjectErrorImage::create([
                    'error_id' => $error->id,
                    'urlImage' => $path
                ]);
        }
        return response()->json($error, 201);
    }

    
    public function update(Request $request, Error $error)
    {
        if (!$error) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validatedData = $request->validate(Error::rules());
        $error->update($validatedData);

        return response()->json($error);
    }

    
    public function destroy(Error $error)
    {
        if (!$error) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $image = $error->errorImage;
        if($image) {
            Storage::delete($image->urlImage);
            $image->delete();    
        }
        $error->delete();
        return response()->json(null, 204);
    }
}
