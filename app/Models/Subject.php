<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // Relacion con SubjectPhoto
    public function photo()
    {
        return $this->hasOne(SubjectPhoto::class);
    }

    // Relación con Specialization
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }


    // Relación con Exclusive
    public function exclusives()
    {
        return $this->hasMany(Exclusive::class);
    }

    // Relación con SubjectBibliographies
    public function bibliographies()
    {
        return $this->hasMany(SubjectBibliographies::class);
    }

    // Relación con SubjectContent
    public function contents()
    {
        return $this->hasMany(SubjectContent::class);
    }

    // Relación con Errors
    public function errors()
    {
        return $this->hasMany(Error::class);
    }

     // Relación con media_archives
     public function archives()
     {
         return $this->hasMany(MediaArchive::class);
     }

    protected $fillable = [
        'specialization_id',
        'title',
        'description',
    ];

    public static function rules()
    {
        return [
            'specialization_id' => 'required|exists:specializations,id',
            'title' => 'required|string|max:50',
            'description' => 'required|string',
        ];
    }

}
