<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group'
    ];

    public function getValueAttribute($value)
    {
        return match($this->type) {
            'boolean' => (boolean) $value,
            'integer' => (int) $value,
            'array' => json_decode($value, true),
            default => $value,
        };
    }
} 