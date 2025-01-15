<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'capacity',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'class_id');
    }
} 