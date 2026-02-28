<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'name',
        'title',
        'bio',
        'photo_path',
        'linkedin_url',
        'github_url',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'user_id' => 'integer',
        ];
    }
}

