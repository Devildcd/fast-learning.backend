<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectContentMedia extends Model
{
    use HasFactory;

    public function subjectContent()
    {
        return $this->belongsTo(SubjectContent::class);
    }

    protected $fillable = ['subject_content_id','path', 'type'];
}
