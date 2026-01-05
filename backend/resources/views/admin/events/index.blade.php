<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Eventos · Backoffice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #020617;
            color: #e5e7eb;
            font-family: system-ui, sans-serif;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 1.6rem;
        }

        .btn {
            background: #22c55e;
            color: #022c22;
            padding: .45rem .9rem;
            border-radius: .5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: .85rem;
        }

        .btn-red {
            background: #ef4444;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .85rem;
        }

        th, td {
            padding: .6rem;
            border-bottom: 1px solid #1f2937;
            text-align: left;
        }

        th {
            color: #9ca3af;
        }

        img {
            width: 70px;
            border-radius: .5rem;
        }

        .badge {
            padding: .15rem .45rem;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 600;
        }

        .active {
            background: rgba(34,197,94,.15);
            color: #4ade80;
        }

        .inactive {
            background: rgba(239,68,68,.15);
            color: #fca5a5;
        }
    </style>
</head>
<body>
<div class="page">

    <div class="top-actions">
        <h1>Eventos</h1>
        <a href="{{ route('admin.events.create') }}" class="btn">+ Criar Evento</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Imagem</th>
            <th>Título</th>
            <th>Data</th>
            <th>Horário</th>
            <th>Capacidade</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse($events as $event)
            <tr>
                <td>
                    @if($event->image_path)
                        <img src="{{ asset('storage/'.$event->image_path) }}">
                    @else
                        —
                    @endif
                </td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->date->format('d/m/Y') }}</td>
                <td>
                    {{ $event->start_time }}
                    @if($event->end_time) → {{ $event->end_time }} @endif
                </td>
                <td>{{ $event->capacity ?? '—' }}</td>
                <td>
                    @if($event->is_active)
                        <span class="badge active">Ativo</span>
                    @else
                        <span class="badge inactive">Inativo</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn">Editar</a>

                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red" onclick="return confirm('Apagar este evento?')">
                            Apagar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Ainda não existem eventos.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
