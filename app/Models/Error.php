<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    // Relación con Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relacion con SubjectErrorPhoto
    public function errorImage()
    {
        return $this->hasOne(SubjectErrorImage::class);
    }


    protected $fillable = [
        'subject_id',
        'name',
        'description',
    ];

    public static function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:50',
            'description' => 'required|string',
        ];
    }
}
