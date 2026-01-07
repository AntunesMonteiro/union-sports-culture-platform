<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;

    //Criar msg
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build(): self
    {
        return $this->subject('Recebemos o teu pedido de reserva')
                    ->markdown('emails.reservations.created');
    }
}
