<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentMedia extends Model
{
    use HasFactory;

    // Relación con Subject-Content
    public function subjectContent()
    {
        return $this->belongsTo(SubjectContent::class);
    }

    protected $fillable = [
        'subject_content_id',
        'media_type',
        'name',
        'description',
        'path',
    ];

    public static function rules()
    {
        return [
            'subject_content_id' => 'required|exists:subject_contents,id',
            'media_type' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'path' => 'required|string|max:255'
        ];
    }
}
