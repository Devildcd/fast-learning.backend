<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectContentDoc extends Model
{
    use HasFactory;

    // Relación con Subject-Content
    public function subjectContent()
    {
        return $this->belongsTo(SubjectContent::class);
    }

    protected $fillable = [
        'subject_content_id',
        'path',
    ];

    public static function rules()
    {
        // return [
        //     'subject_content_id' => 'required|exists:subject_contents,id',
        //     'path' => 'max:255',
        // ];
    }
}
