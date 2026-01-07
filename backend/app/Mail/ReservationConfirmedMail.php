<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;

    //Criar msg
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Reserva confirmada - Union Sports & Culture')
            ->markdown('emails.reservations.confirmed', [
                'reservation' => $this->reservation,
            ]);
    }
}
