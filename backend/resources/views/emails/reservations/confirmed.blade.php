@component('mail::message')
# Reserva confirmada 🎉

Olá {{ $reservation->customer_name }},

A tua reserva no **Union Sports & Culture** foi **confirmada**.

@component('mail::panel')
**Data:** {{ \Illuminate\Support\Carbon::parse($reservation->date)->format('d/m/Y') }}  
**Hora:** {{ \Illuminate\Support\Carbon::parse($reservation->time)->format('H:i') }}  
**Nº de pessoas:** {{ $reservation->num_people }}

@isset($reservation->event)
**Evento:** {{ $reservation->event->title }}
@endisset
@endcomponent

Se precisares de alterar ou cancelar a reserva, responde a este email ou contacta-nos diretamente.

Obrigado,  
**Union Sports & Culture**
@endcomponent
