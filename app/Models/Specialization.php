<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    protected $fillable = [
        'profile_id',
        'name',
        'description',
    ];

    public static function rules()
    {
        return [
            'profile_id' => 'required',
            'name' => 'required|string|max:50',
            'description' => 'required|string',
        ];
    }
}
