<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';

    protected $fillable = [
        'movie_id',
        'cinema_id',
        'auditorium_id',
        'type_id',
        'visit_date',
        'row',
        'seat',
        'price',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function auditorium()
    {
        return $this->belongsTo(Auditorium::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
