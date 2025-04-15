<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;

    protected $table = 'cinemas';

    protected $fillable = [
        'cinema_chain_id',
        'name',
        'location',
        'description',
    ];

    public function cinemaChain()
    {
        return $this->belongsTo(CinemaChain::class);
    }

    public function auditoriums()
    {
        return $this->hasMany(Auditorium::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function cinemaPriceHistories()
    {
        return $this->hasMany(CinemaPriceHistory::class);
    }
}
