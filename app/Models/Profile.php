<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable = [
        'category_id',
        'name',
        'description',
    ];

    public static function rules()
    {
        return [
            'category_id' => 'required',
            'name' => 'required|string|max:50',
            'description' => 'required|string',
        ];
    }
}
