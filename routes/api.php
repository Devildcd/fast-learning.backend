<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentLevelController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ExclusiveController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubjectBibliographiesController;
use App\Http\Controllers\SubjectContentController;
use App\Http\Controllers\SubjectContentDocController;
use App\Http\Controllers\SubjectContentImageController;
use App\Http\Controllers\SubjectContentMediaController;
use App\Http\Controllers\SubjectErrorImageController;
use App\Http\Controllers\SubjectPhotoController;
use App\Http\Controllers\ExclusiveImageController;
use App\Http\Controllers\ExclusiveDocController;
use App\Http\Controllers\MediaArchiveController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// rutas protegidas para categories
Route::get('/categories', [CategoryController::class, 'index']); 
Route::get('/category/{category}', [CategoryController::class, 'show']); 
Route::post('/category', [CategoryController::class, 'store']); 
Route::put('/category/{category}', [CategoryController::class, 'update']); 
Route::delete('/category/{category}', [CategoryController::class, 'destroy']); 

// Rutas protegidas para subjects 
Route::get('/subjects', [SubjectController::class, 'index']);
Route::get('/subject/{subject}', [SubjectController::class, 'show']);
Route::get('/subject-filter', [SubjectController::class, 'subjectsFilter']);
Route::post('/subject', [SubjectController::class, 'store']);
Route::put('/subject/{subject}', [SubjectController::class, 'update']);
Route::delete('/subject/{subject}', [SubjectController::class, 'destroy']);

// Rutas protegidas para subject-photo
Route::post('/photo', [SubjectPhotoController::class, 'store']);
Route::delete('/photo/{photo}', [SubjectPhotoController::class, 'destroy']);

// Rutas protegidas para profiles
Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profile/{profile}', [ProfileController::class, 'show']);
Route::get('/profile-filter', [ProfileController::class, 'profilesFilter']);
Route::post('/profile', [ProfileController::class, 'store']);
Route::put('/profile/{profile}', [ProfileController::class, 'update']);
Route::delete('/profile/{profile}', [ProfileController::class, 'destroy']);

// Rutas protegidas para specializations
Route::get('/specializations', [SpecializationController::class, 'index']);
Route::get('/specialization/{specialization}', [SpecializationController::class, 'show']);
Route::get('/specialization-filter', [SpecializationController::class, 'specializationsFilter']);
Route::post('/specialization', [SpecializationController::class, 'store']);
Route::put('/specialization/{specialization}', [SpecializationController::class, 'update']);
Route::delete('/specialization/{specialization}', [SpecializationController::class, 'destroy']);

// Rutas protegidas para content-level
Route::get('/levels', [ContentLevelController::class, 'index']);
Route::get('/level/{level}', [ContentLevelController::class, 'show']); 
Route::post('/level', [ContentLevelController::class, 'store']);
Route::put('/level/{level}', [ContentLevelController::class, 'update']);
Route::delete('/level/{level}', [ContentLevelController::class, 'destroy']);

// Rutas protegidas para content-type
Route::get('/types', [ContentTypeController::class, 'index']);
Route::get('/type/{type}', [ContentTypeController::class, 'show']);
Route::post('/type', [ContentTypeController::class, 'store']);
Route::put('/type/{type}', [ContentTypeController::class, 'update']);
Route::delete('/type/{type}', [ContentTypeController::class, 'destroy']);

// Rutas protegidas para subject-content
Route::get('/contents/{subject}', [SubjectContentController::class, 'index']);
Route::get('/content/{content}', [SubjectContentController::class, 'show']);
Route::get('/content-filter', [SubjectContentController::class, 'contentsFilter']);
Route::post('/content', [SubjectContentController::class, 'store']);
Route::put('/content/{content}', [SubjectContentController::class, 'update']);
Route::delete('/content/{content}', [SubjectContentController::class, 'destroy']);

// Rutas protegidas para exclusive
Route::get('/exclusives/{subject}', [ExclusiveController::class, 'index']);
Route::get('/exclusive/{exclusive}', [ExclusiveController::class, 'show']);
Route::post('/exclusive', [ExclusiveController::class, 'store']);
Route::put('/exclusive/{exclusive}', [ExclusiveController::class, 'update']);
Route::delete('/exclusive/{exclusive}', [ExclusiveController::class, 'destroy']);

// Rutas protegidas para error
Route::get('/errors/{subject}', [ErrorController::class, 'index']);
Route::get('/error/{error}', [ErrorController::class, 'show']);
Route::post('/error', [ErrorController::class, 'store']);
Route::put('/error/{error}', [ErrorController::class, 'update']);
Route::delete('/error/{error}', [ErrorController::class, 'destroy']);

// Rutas protegidas para subject-error-image
Route::post('/image-error', [SubjectErrorImageController::class, 'store']);
Route::delete('/image-error/{image}', [SubjectErrorImageController::class, 'destroy']);

// Rutas protegidas para subject-content-image
Route::post('/subject-content-media', [SubjectContentMediaController::class, 'store']);
Route::post('/image-content', [SubjectContentImageController::class, 'store']);
Route::delete('/image-content/{image}', [SubjectContentImageController::class, 'destroy']);
Route::delete('/delete-all-images-content/{content}', [SubjectContentImageController::class, 'deleteAllImages']);

// Rutas protegidas para subject-content-doc
Route::post('/doc-content', [SubjectContentDocController::class, 'store']);
Route::delete('/doc-content/{doc}', [SubjectContentDocController::class, 'destroy']);

// Rutas protegidas para exclusive-images
Route::post('/image-exclusive', [ExclusiveImageController::class, 'store']);
Route::delete('/image-exclusive/{image}', [ExclusiveImageController::class, 'destroy']);
Route::delete('/delete-all-images-exclusive/{content}', [ExclusiveImageController::class, 'deleteAllImages']);

// Rutas protegidas para exclusive-doc
Route::post('/doc-exclusive', [ExclusiveDocController::class, 'store']);
Route::delete('/doc-exclusive/{doc}', [ExclusiveDocController::class, 'destroy']);

// Rutas protegidas para subject-bibliographies
Route::get('/bibliographies/{subject}', [SubjectBibliographiesController::class, 'index']);
Route::get('/bibliography/{bibliography}', [SubjectBibliographiesController::class, 'show']);
Route::post('/bibliography', [SubjectBibliographiesController::class, 'store']);
Route::put('/bibliography/{bibliography}', [SubjectBibliographiesController::class, 'update']);
Route::delete('/bibliography/{bibliography}', [SubjectBibliographiesController::class, 'destroy']);

// Rutas protegidas para media_archives
Route::get('/doc-archives/{subject}', [MediaArchiveController::class, 'index']);
Route::post('/doc-archive', [MediaArchiveController::class, 'store']);
Route::delete('/doc-archive/{doc}', [MediaArchiveController::class, 'destroy']);


