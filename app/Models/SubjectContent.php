<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectContent extends Model
{
    use HasFactory;

    // Relación con Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relación con Content-level
    public function contentLevel()
    {
        return $this->belongsTo(ContentLevel::class);
    }

    // Relación con Content-Type
    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }

    // Relacion con SubjectContentImage
    public function subjectContentImages()
    {
        return $this->hasMany(SubjectContentImage::class);
    }

    // Relacion con SubjectContentDoc
    public function subjectContentDocs()
    {
        return $this->hasMany(SubjectContentDoc::class);
    }

    // Relacion con SubjectContentMedia
    public function subjectContentMedia()
    {
        return $this->hasMany(SubjectContentMedia::class);
    }

    protected $fillable = [
        'subject_id',
        'content_level_id',
        'content_type_id',
        'name',
        'usage_level',
        'description',
    ];

    public static function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'content_level_id' => 'required|exists:content_levels,id',
            'content_type_id' => 'required|exists:content_types,id',
            'name' => 'required|string|max:50',
            'usage_level' => 'required|string|max:50',
            'description' => 'required|string',
        ];
    }
}
