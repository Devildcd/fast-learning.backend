<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectErrorImage extends Model
{
    use HasFactory;

    public function error() 
    {
        return $this->hasOne(Error::class);
    }

    protected $fillable = [
        'error_id',
        'urlImage'
    ];

    public static function rules()
    {
        return [
            'error_id' => 'required',
            'urlImage' => 'max:255'
        ];
    }
}
