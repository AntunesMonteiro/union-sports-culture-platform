@component('mail::message')
# Olá {{ $reservation->customer_name }},

Recebemos o teu **pedido de reserva** no Union Sports &amp; Culture.  
A nossa equipa vai confirmá-lo assim que possível.

@component('mail::panel')
**Data:** {{ \Illuminate\Support\Carbon::parse($reservation->date)->format('d/m/Y') }}  
**Hora:** {{ \Illuminate\Support\Carbon::parse($reservation->time)->format('H:i') }}  
**Nº de pessoas:** {{ $reservation->num_people }}

@if($reservation->event)
**Evento:** {{ $reservation->event->title }}
@endif
@endcomponent

Se precisares de alterar ou cancelar a reserva, responde a este email ou contacta-nos diretamente.

Obrigado,  
**Union Sports &amp; Culture**
@endcomponent
