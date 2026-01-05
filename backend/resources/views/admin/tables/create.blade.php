<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Mesa · Backoffice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #020617;
            color: #e5e7eb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .page {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .card {
            background: #02081a;
            border: 1px solid #1f2937;
            border-radius: 1rem;
            padding: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: .2rem;
            font-size: .85rem;
            color: #9ca3af;
        }

        input, select {
            width: 100%;
            padding: .45rem .55rem;
            border-radius: .5rem;
            border: 1px solid #1f2937;
            background: #020617;
            color: #e5e7eb;
            margin-bottom: 1rem;
        }

        .btn {
            background: #22c55e;
            color: #022c22;
            border-radius: .5rem;
            padding: .5rem 1.2rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        .link {
            font-size: .8rem;
            color: #9ca3af;
            display: inline-block;
            margin-top: .5rem;
            text-decoration: none;
        }

        .error {
            color: #fca5a5;
            font-size: .75rem;
            margin-top: -.8rem;
            margin-bottom: .6rem;
        }
    </style>
</head>
<body>
<div class="page">
    <h1>Criar Nova Mesa</h1>

    <div class="card">
        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf

            <label>Nome da Mesa</label>
            <input type="text" name="name" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <label>Capacidade</label>
            <input type="number" name="capacity" min="1" required>
            @error('capacity') <div class="error">{{ $message }}</div> @enderror

            <label>Zona</label>
            <select name="zone" required>
                <option value="interior">Interior</option>
                <option value="exterior">Exterior</option>
                <option value="bar">Bar</option>
            </select>
            @error('zone') <div class="error">{{ $message }}</div> @enderror

            <button class="btn">Guardar Mesa</button>
        </form>

        <a href="{{ route('admin.tables.index') }}" class="link">← Voltar às mesas</a>
    </div>
</div>
</body>
</html>
