<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    use HasFactory;

    public function subjectContents()
    {
        return $this->hasMany(SubjectContent::class);
    }

    protected $fillable = [
        'name',
        'description',
    ];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'required|string',
        ];
    }
}
