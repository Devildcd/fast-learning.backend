<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExclusiveImage extends Model
{
    use HasFactory;

    public function exclusive()
    {
        return $this->belongsTo(Exclusive::class);
    }

    protected $fillable = [
        'exclusive_id',
        'path',
    ];

    public static function rules()
    {
        return [
            'exclusive_id' => 'required|exists:exclusives,id',
            'path' => 'max:255',
        ];
    }
}
