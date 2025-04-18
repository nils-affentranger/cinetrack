<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = [
        'name',
        'description',
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function cinemaTypePrices()
    {
        return $this->hasMany(CinemaTypePrice::class);
    }
}
