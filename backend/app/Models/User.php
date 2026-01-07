<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // , HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Um utilizador pode criar reservas
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Um utilizador pode criar muitos eventos
    public function eventsCreated()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    // Um utilizador pode criar muitos bloqueios
    public function blocksCreated()
    {
        return $this->hasMany(Block::class, 'created_by');
    }
}
