<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'credits',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credits' => 'integer'
    ];

    public function professors()
    {
        return $this->belongsToMany(Professor::class);
    }
} 