<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'date',
        'time',
        'num_people',
        'table_id',
        'event_id',
        'status',
        'source',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Reserva pertence a uma mesa
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Reserva pertence a um evento (opcional)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Reserva pode ter sido criada por um utilizador (staff)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
