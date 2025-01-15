<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CahierTexte extends Model
{
    protected $table = 'cahier_textes';
    
    protected $fillable = [
        'professor_id',
        'course_id',
        'date',
        'content'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
} 