<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard · Union Sports & Culture</title>
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
            --warning: #eab308;
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
            font-size: 1.6rem;
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

        .grid {
            display: grid;
            grid-template-columns: 2fr 1.2fr;
            gap: 1.25rem;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .9rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 700px) {
            .kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .card {
            background: var(--bg-card);
            border-radius: 1rem;
            border: 1px solid var(--border-subtle);
            padding: 1rem;
        }

        .card-title {
            font-size: .9rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--text-muted);
            margin-bottom: .75rem;
        }

        .kpi {
            padding: .75rem .85rem;
            border-radius: .9rem;
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(31, 41, 55, 0.9);
        }

        .kpi-label {
            font-size: .75rem;
            color: var(--text-muted);
            margin-bottom: .15rem;
        }

        .kpi-value {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .kpi-sub {
            font-size: .75rem;
            color: var(--text-muted);
            margin-top: .1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .8rem;
        }

        th, td {
            padding: .45rem .4rem;
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
            background: rgba(15, 23, 42, 0.25);
        }

        td {
            border-bottom: 1px solid rgba(31, 41, 55, 0.6);
        }

        .small {
            font-size: .75rem;
            color: var(--text-muted);
        }

        .nowrap { white-space: nowrap; }

        .tag {
            display: inline-flex;
            padding: .1rem .4rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            font-size: .7rem;
            color: var(--text-muted);
        }

        .occupancy-bar {
            height: 6px;
            border-radius: 999px;
            background: rgba(31, 41, 55, 0.9);
            overflow: hidden;
            margin-top: .25rem;
        }

        .occupancy-fill {
            height: 100%;
            background: linear-gradient(90deg, #22c55e, #4ade80);
        }

        .pill-warning {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            border-radius: 999px;
            padding: .15rem .6rem;
            font-size: .7rem;
            background: rgba(250, 204, 21, 0.1);
            color: #facc15;
            border: 1px solid rgba(250, 204, 21, 0.5);
        }

        .mt-1 { margin-top: .25rem; }
        .mt-2 { margin-top: .5rem; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="title-block">
            <div class="badge">
                <span class="badge-dot"></span>
                <span>Backoffice · Dashboard</span>
            </div>
            <h1>Resumo de reservas</h1>
            <p>Hoje: {{ $today->format('d/m/Y') }} · visão rápida de reservas e eventos.</p>
        </div>
    </div>

    <div class="grid">
        {{-- Coluna principal --}}
        <div>
            <div class="kpi-grid">
                <div class="kpi">
                    <div class="kpi-label">Reservas hoje</div>
                    <div class="kpi-value">{{ $totalToday }}</div>
                    <div class="kpi-sub">Inclui todas as origens e estados.</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">Pendentes hoje</div>
                    <div class="kpi-value">{{ $pendingToday }}</div>
                    <div class="kpi-sub">Aguarda confirmação da equipa.</div>
                </div>
                <div class="kpi">
                    <div class="kpi-label">Confirmadas hoje</div>
                    <div class="kpi-value">{{ $confirmedToday }}</div>
                    <div class="kpi-sub">Já comunicadas ao cliente.</div>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Reservas de hoje</div>

                @if ($reservationsToday->isEmpty())
                    <p class="small">Ainda não há reservas para hoje.</p>
                @else
                    <table>
                        <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Pessoas</th>
                            <th>Mesa</th>
                            <th>Evento</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservationsToday as $reservation)
                            <tr>
                                <td class="nowrap">
                                    {{ \Illuminate\Support\Carbon::parse($reservation->time)->format('H:i') }}
                                </td>
                                <td>
                                    {{ $reservation->customer_name }}
                                    @if ($reservation->customer_phone)
                                        <div class="small">📞 {{ $reservation->customer_phone }}</div>
                                    @endif
                                </td>
                                <td>{{ $reservation->num_people }}</td>
                                <td>
                                    @if ($reservation->table)
                                        {{ $reservation->table->name }}
                                    @else
                                        <span class="tag">Por atribuir</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($reservation->event)
                                        {{ $reservation->event->title }}
                                    @else
                                        <span class="small">Normal</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="tag">{{ ucfirst($reservation->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="card mt-2">
                <div class="card-title">Últimos 7 dias · nº de reservas</div>
                @if ($reservationsLast7Days->isEmpty())
                    <p class="small">Ainda não há histórico suficiente.</p>
                @else
                    <table>
                        <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reservationsLast7Days as $day => $total)
                            <tr>
                                <td>{{ $day }}</td>
                                <td>{{ $total }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Coluna lateral: eventos --}}
        <div>
            <div class="card">
                <div class="card-title">Próximos eventos</div>

                @if ($upcomingEvents->isEmpty())
                    <p class="small">Não existem eventos ativos nos próximos dias.</p>
                @else
                    <table>
                        <thead>
                        <tr>
                            <th>Evento</th>
                            <th class="nowrap">Data</th>
                            <th>Lotação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($upcomingEvents as $item)
                            @php
                                /** @var \App\Models\Event $event */
                                $event = $item['event'];
                                $capacity = $item['capacity'];
                                $current = $item['currentPeople'];
                                $occ = $item['occupancy'];
                            @endphp
                            <tr>
                                <td>
                                    {{ $event->title }}
                                    @if ($event->start_time)
                                        <div class="small">
                                            {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="nowrap">
                                    {{ \Illuminate\Support\Carbon::parse($event->date)->format('d/m') }}
                                </td>
                                <td>
                                    @if ($capacity > 0)
                                        <div class="small">
                                            {{ $current }} / {{ $capacity }}
                                            @if (!is_null($occ))
                                                ({{ $occ }}%)
                                            @endif
                                        </div>
                                        <div class="occupancy-bar">
                                            <div class="occupancy-fill" style="width: {{ min($occ ?? 0, 100) }}%"></div>
                                        </div>

                                        @if ($occ !== null && $occ >= 90)
                                            <div class="pill-warning mt-1">
                                                ● Evento quase cheio
                                            </div>
                                        @endif
                                    @else
                                        <span class="small">Sem limite definido</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
