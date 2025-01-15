<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'professor_id',
        'subject_id',
        'class_id',
        'semester',
        'hours',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
} 