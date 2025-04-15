<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CinemaTypePrice extends Model
{
    protected $table = 'cinema_type_prices';

    protected $fillable = [
        'cinema_chain_id',
        'type_id',
        'surcharge',
        'effective_from',
        'effective_to',
    ];

    public function cinemaChain()
    {
        return $this->belongsTo(CinemaChain::class);
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class);
    }
}
