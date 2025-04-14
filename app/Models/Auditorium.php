<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditorium extends Model
{
    protected $table = 'auditoriums';

    protected $fillable = [
        'cinema_id',
        'name',
        'description',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
