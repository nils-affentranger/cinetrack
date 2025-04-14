<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaTicketTypePrice extends Model
{
    use HasFactory;

    protected $table = 'cinema_ticket_type_prices';

    protected $fillable = [
        'cinema_chain_id',
        'ticket_type_id',
        'surcharge',
        'effective_from',
        'effective_to',
    ];

    public function cinemaChain()
    {
        return $this->belongsTo(CinemaChain::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
