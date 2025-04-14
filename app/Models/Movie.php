<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = [
        'title',
        'tmdb_id',
        'poster_path',
        'runtime',
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
