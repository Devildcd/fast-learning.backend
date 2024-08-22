<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectPhoto extends Model
{
    use HasFactory;

    public function subject() 
    {
        return $this->hasOne(Subject::class);
    }

    protected $fillable = [
        'subject_id',
        'urlPhoto'
    ];

    public static function rules()
    {
        return [
            'subject_id' => 'required',
            'urlPhoto' => 'required'
        ];
    }
}
