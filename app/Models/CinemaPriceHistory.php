<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaPriceHistory extends Model
{
    use HasFactory;

    protected $table = 'cinema_price_history';

    protected $fillable = [
        'cinema_id',
        'base_price',
        'effective_from',
        'effective_to',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function cinemaChain()
    {
        return $this->belongsTo(CinemaChain::class);
    }
}
