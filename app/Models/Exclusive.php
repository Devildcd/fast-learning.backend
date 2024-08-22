<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exclusive extends Model
{
    use HasFactory;

     // Relación con Subject
     public function subject()
     {
         return $this->belongsTo(Subject::class);
     }
 
     // Relación con Exclusive_image
     public function exclusiveImages()
     {
         return $this->hasMany(ExclusiveImage::class);
     }

     // Relación con Exclusive_doc
     public function exclusiveDocs()
     {
         return $this->hasMany(ExclusiveDoc::class);
     }
 
     protected $fillable = [
         'subject_id',
         'name',
         'description',
         'availability'
     ];
 
     public static function rules()
     {
         return [
             'subject_id' => 'required|exists:subjects,id',
             'name' => 'required|string|max:50',
             'description' => 'required|string',
             'availability' => 'required|string|max:50'
         ];
     }
 
}
