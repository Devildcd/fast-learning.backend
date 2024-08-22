<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectBibliographies extends Model
{
    use HasFactory;

    // Relación con Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    protected $fillable = [
        'subject_id',
        'url',
        'description',
        'type',
    ];

    protected $casts = [
        'type' => 'boolean',
    ];

    public static function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
            'url' => 'required|string|max:255',
            'type' => 'boolean'
        ];
    }
}
