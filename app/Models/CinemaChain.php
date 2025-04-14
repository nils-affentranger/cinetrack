<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CinemaChain extends Model
{
    protected $table = 'cinema_chains';

    protected $fillable = [
        'name',
        'description',
    ];

    public function cinemas()
    {
        return $this->hasMany(Cinema::class);
    }

    public function cinemaPriceHistories()
    {
        return $this->hasMany(CinemaPriceHistory::class);
    }

    public function cinemaTicketTypePrices()
    {
        return $this->hasMany(CinemaTicketTypePrice::class);
    }
}
