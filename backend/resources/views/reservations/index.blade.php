<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Reservas · Backoffice - Union Sports & Culture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg-main: #020617;
            --bg-card: #02081a;
            --border-subtle: #1f2937;
            --accent: #22c55e;
            --accent-soft: rgba(34, 197, 94, 0.12);
            --text-main: #e5e7eb;
            --text-muted: #9ca3af;
            --danger: #ef4444;
            --pending: #eab308;
        }

        * { box-sizing: border-box; }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top, #0f172a 0, #020617 45%, #020617 100%);
            color: var(--text-main);
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .title-block h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .title-block p {
            margin: .25rem 0 0;
            font-size: .85rem;
            color: var(--text-muted);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .25rem .7rem;
            border-radius: 999px;
            border: 1px solid var(--border-subtle);
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-soft);
        }

        .filter-card {
            background: rgba(15, 23, 42, 0.9);
            border-radius: .85rem;
            border: 1px solid var(--border-subtle);
            padding: .75rem 1rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .75rem 1rem;
            margin-bottom: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .filter-card label {
            font-size: .75rem;
            color: var(--text-muted);
        }

        .filter-card input[type="date"],
        .filter-card select {
            padding: .35rem .5rem;
            border-radius: .5rem;
            border: 1px solid var(--border-subtle);
            background: #020617;
            color: var(--text-main);
            font-size: .8rem;
            min-width: 160px;
        }

        .filter-card button {
            border-radius: 999px;
            border: none;
            padding: .45rem 1rem;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            background: var(--accent);
            color: #022c22;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .filter-card .btn-secondary {
            background: transparent;
            border: 1px solid var(--border-subtle);
            color: var(--text-main);
        }

        .pill {
            font-size: .75rem;
            color: var(--text-muted);
        }

        .card {
            background: var(--bg-card);
            border-radius: 1rem;
            border: 1px solid var(--border-subtle);
            padding: 1rem;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .8rem;
        }

        th, td {
            padding: .55rem .5rem;
            text-align: left;
        }

        thead {
            background: rgba(15, 23, 42, 0.9);
        }

        th {
            font-weight: 500;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-subtle);
        }

        tbody tr:nth-child(odd) {
            background: rgba(15, 23, 42, 0.5);
        }

        tbody tr:nth-child(even) {
            background: rgba(15, 23, 42, 0.2);
        }

        td {
            border-bottom: 1px solid rgba(31, 41, 55, 0.6);
        }

        .status-form {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            margin-left: .4rem;
        }

        .status-select {
            background: transparent;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            font-size: .7rem;
            padding: .15rem .5rem;
            color: var(--text-muted);
        }

        .status-select:focus {
            outline: none;
            border-color: var(--accent);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            border-radius: 999px;
            padding: .15rem .6rem;
            font-size: .7rem;
            font-weight: 500;
        }

        .status-pending {
            background: rgba(234, 179, 8, 0.1);
            color: #facc15;
            border: 1px solid rgba(234, 179, 8, 0.4);
        }

        .status-confirmed {
            background: rgba(34, 197, 94, 0.1);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        .status-cancelled,
        .status-no_show {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .status-seated {
            background: rgba(59, 130, 246, 0.1);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .empty {
            padding: .75rem 0;
            font-size: .85rem;
            color: var(--text-muted);
            text-align: center;
        }

        .small {
            font-size: .75rem;
            color: var(--text-muted);
        }

        .nowrap {
            white-space: nowrap;
        }

        .tag {
            display: inline-flex;
            padding: .1rem .4rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            font-size: .7rem;
            color: var(--text-muted);
        }

        @media (max-width: 800px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .card {
                padding: .5rem;
            }

            .filter-card {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-card input[type="date"],
            .filter-card select {
                width: 100%;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tbody tr {
                margin-bottom: .6rem;
                border-radius: .7rem;
                overflow: hidden;
            }

            tbody td {
                border-bottom: none;
                padding: .3rem .6rem;
            }

            tbody td::before {
                content: attr(data-label);
                display: block;
                font-size: .7rem;
                color: var(--text-muted);
                margin-bottom: .1rem;
            }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="title-block">
            <div class="badge">
                <span class="badge-dot"></span>
                <span>Backoffice · Reservas</span>
            </div>

            @if(!empty($selectedDate))
                <h1>Reservas para {{ \Illuminate\Support\Carbon::parse($selectedDate)->format('d/m/Y') }}</h1>
            @else
                <h1>Todas as reservas</h1>
            @endif

            <p>Vista interna das reservas do Union Sports &amp; Culture. Usa os filtros para refinar.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('reservations.index') }}" class="filter-card">
        <div class="filter-group">
            <label for="date">Data</label>
            <input type="date" id="date" name="date" value="{{ $selectedDate ?? '' }}">
        </div>

        <div class="filter-group">
            <label for="event_id">Evento</label>
            <select name="event_id" id="event_id">
                <option value="">Todos os eventos</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ ($selectedEventId == $event->id) ? 'selected' : '' }}>
                        {{ \Illuminate\Support\Carbon::parse($event->date)->format('d/m') }}
                        @if ($event->start_time)
                            · {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }}
                        @endif
                        — {{ $event->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="status">Estado</label>
            <select name="status" id="status">
                <option value="">Todos os estados</option>
                @foreach ($statuses as $key => $label)
                    <option value="{{ $key }}" {{ ($selectedStatus === $key) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Filtrar</button>

        {{-- Botão limpar filtros (só aparece se houver algum filtro ativo) --}}
        @if(!empty($selectedDate) || !empty($selectedEventId) || !empty($selectedStatus))
            <a href="{{ route('reservations.index') }}" class="filter-card button btn-secondary"
               style="text-decoration:none; text-align:center;">
                Limpar filtros
            </a>
        @endif

        <div class="pill">
            Total: {{ $reservations->count() }} reserva(s)
        </div>
    </form>

    <div class="card">
        @if ($reservations->isEmpty())
            <div class="empty">
                Ainda não há reservas para estes filtros.
            </div>
        @else
            <table>
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Pessoas</th>
                    <th>Mesa</th>
                    <th>Evento</th>
                    <th>Origem</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td class="nowrap" data-label="Data">
                            {{ \Illuminate\Support\Carbon::parse($reservation->date)->format('d/m/Y') }}
                        </td>
                        <td class="nowrap" data-label="Hora">
                            {{ \Illuminate\Support\Carbon::parse($reservation->time)->format('H:i') }}
                        </td>
                        <td data-label="Cliente">
                            {{ $reservation->customer_name }}
                            @if ($reservation->notes)
                                <div class="small">Notas: {{ $reservation->notes }}</div>
                            @endif
                        </td>
                        <td data-label="Contacto">
                            @if ($reservation->customer_phone)
                                <div class="small">📞 {{ $reservation->customer_phone }}</div>
                            @endif
                            @if ($reservation->customer_email)
                                <div class="small">✉️ {{ $reservation->customer_email }}</div>
                            @endif
                        </td>
                        <td data-label="Pessoas">
                            {{ $reservation->num_people }}
                        </td>
                        <td data-label="Mesa">
                            @if ($reservation->table)
                                {{ $reservation->table->name }}
                                <div class="small">
                                    {{ $reservation->table->capacity }} pax · {{ ucfirst($reservation->table->zone) }}
                                </div>
                            @else
                                <span class="tag">Por atribuir</span>
                            @endif
                        </td>
                        <td data-label="Evento">
                            @if ($reservation->event)
                                {{ $reservation->event->title }}
                                <div class="small">
                                    {{ \Illuminate\Support\Carbon::parse($reservation->event->date)->format('d/m') }}
                                    @if ($reservation->event->start_time)
                                        · {{ \Illuminate\Support\Carbon::parse($reservation->event->start_time)->format('H:i') }}
                                    @endif
                                </div>
                            @else
                                <span class="small">Reserva normal</span>
                            @endif
                        </td>
                        <td data-label="Origem">
                            <span class="tag">{{ ucfirst($reservation->source) }}</span>
                        </td>
                        <td data-label="Estado">
                            @php $status = $reservation->status; @endphp

                            <span class="status-badge status-{{ $status }}">
                                @switch($status)
                                    @case('pending')
                                        ● Pendente
                                        @break
                                    @case('confirmed')
                                        ● Confirmada
                                        @break
                                    @case('seated')
                                        ● Em mesa
                                        @break
                                    @case('cancelled')
                                        ● Cancelada
                                        @break
                                    @case('no_show')
                                        ● No-show
                                        @break
                                    @default
                                        ● {{ $status }}
                                @endswitch
                            </span>

                            <form method="POST"
                                  action="{{ route('reservations.updateStatus', $reservation) }}"
                                  class="status-form">
                                @csrf
                                <select name="status"
                                        class="status-select"
                                        onchange="this.form.submit()">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected($reservation->status === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
</body>
</html>
