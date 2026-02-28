<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'starts_at',
        'ends_at',
        'location',
        'description',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
