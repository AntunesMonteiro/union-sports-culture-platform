@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">

    {{-- Título --}}
    <h1 class="text-2xl font-bold mb-6">
        Histórico da Reserva #{{ $reservation->id }}
    </h1>

    {{-- Erro Node API --}}
    @if(!empty($error))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
            {{ $error }}
        </div>
    @endif

    {{-- Resumo da reserva --}}
    <div class="bg-white shadow rounded p-4 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <p><strong>Cliente:</strong> {{ $reservation->customer_name }}</p>
            <p><strong>Telefone:</strong> {{ $reservation->customer_phone ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $reservation->customer_email ?? '-' }}</p>
            <p><strong>Data:</strong> {{ $reservation->date->format('d/m/Y') }} às {{ $reservation->time }}</p>
            <p><strong>Nº Pessoas:</strong> {{ $reservation->num_people }}</p>
            <p><strong>Estado atual:</strong> {{ ucfirst($reservation->status) }}</p>

            @if($reservation->table)
                <p><strong>Mesa:</strong> {{ $reservation->table->name }}</p>
                <p><strong>Zona:</strong> {{ ucfirst($reservation->table->zone) }}</p>
            @endif

            @if($reservation->event)
                <p class="md:col-span-2">
                    <strong>Evento:</strong> {{ $reservation->event->title }}
                </p>
            @endif
        </div>
    </div>

    {{-- Timeline --}}
    <h2 class="text-xl font-semibold mb-4">Timeline de ações</h2>

    @if(empty($logs))
        <p class="text-gray-600">Sem histórico disponível para esta reserva.</p>
    @else
        <ol class="relative border-l border-gray-300 ml-4">
            @foreach($logs as $log)
                <li class="mb-8 ml-6">
                    <span class="absolute -left-3 flex items-center justify-center w-6 h-6 bg-blue-600 rounded-full ring-8 ring-white text-white text-xs">
                        •
                    </span>

                    <div class="bg-gray-50 p-4 rounded shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">
                            {{ \Carbon\Carbon::parse($log['createdAt'])->format('d/m/Y H:i') }}
                        </p>

                        <p class="font-medium text-gray-900">
                            {{ ucfirst(str_replace('_', ' ', $log['action'])) }}
                        </p>

                        {{-- Mudança de estado --}}
                        @if(!empty($log['old_status']) || !empty($log['new_status']))
                            <p class="text-sm mt-1">
                                Estado:
                                <span class="font-semibold">{{ $log['old_status'] ?? '-' }}</span>
                                →
                                <span class="font-semibold">{{ $log['new_status'] ?? '-' }}</span>
                            </p>
                        @endif

                        {{-- Actor --}}
                        <p class="text-sm text-gray-600 mt-1">
                            Origem: <strong>{{ $log['source'] }}</strong>
                            @if(!empty($log['actor_user_id']))
                                | Utilizador ID: <strong>{{ $log['actor_user_id'] }}</strong>
                            @endif
                        </p>

                        {{-- Metadata --}}
                        @if(!empty($log['meta']))
                            <details class="mt-3">
                                <summary class="cursor-pointer text-sm text-blue-600">
                                    Ver detalhes
                                </summary>
                                <pre class="text-xs bg-gray-100 p-3 mt-2 rounded overflow-auto">
{{ json_encode($log['meta'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                                </pre>
                            </details>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    @endif

    {{-- Voltar --}}
    <div class="mt-8">
        <a href="{{ route('reservations.index', ['date' => $reservation->date]) }}"
           class="inline-block text-blue-600 hover:underline">
            ← Voltar à lista de reservas
        </a>
    </div>

</div>
@endsection
