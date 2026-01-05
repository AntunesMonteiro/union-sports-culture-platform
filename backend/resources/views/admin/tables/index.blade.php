<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Mesas · Backoffice - Union Sports & Culture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #020617;
            color: #e5e7eb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .page {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .btn {
            background: #22c55e;
            color: #022c22;
            text-decoration: none;
            padding: .45rem .9rem;
            border-radius: .5rem;
            font-size: .85rem;
            font-weight: 600;
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
        }

        th {
            color: #9ca3af;
            text-align: left;
        }

        tr:hover {
            background: rgba(15, 23, 42, 0.7);
        }

        .tag {
            display: inline-block;
            padding: .15rem .45rem;
            border-radius: 999px;
            font-size: .7rem;
            border: 1px solid rgba(148, 163, 184, 0.3);
            color: #9ca3af;
        }
    </style>
</head>
<body>
<div class="page">

    <div class="top-actions">
        <h1>Mesas</h1>

        <a href="{{ route('admin.tables.create') }}" class="btn">
            + Criar Mesa
        </a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Capacidade</th>
            <th>Zona</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse($tables as $table)
            <tr>
                <td>{{ $table->name }}</td>
                <td>{{ $table->capacity }}</td>
                <td>
                    <span class="tag">{{ ucfirst($table->zone) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.tables.edit', $table) }}" class="btn">
                        Editar
                    </a>

                    <form method="POST" action="{{ route('admin.tables.destroy', $table) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red" onclick="return confirm('Apagar esta mesa?')">
                            Apagar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Ainda não existem mesas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
