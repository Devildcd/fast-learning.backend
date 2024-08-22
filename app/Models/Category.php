<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function profiles()
    {
        return $this->hasMany(Profile::class);
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
