<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Evento · Backoffice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #020617;
            color: #e5e7eb;
            font-family: system-ui, sans-serif;
        }

        .page {
            max-width: 700px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
        }

        .card {
            background: #02081a;
            border-radius: 1rem;
            border: 1px solid #1f2937;
            padding: 1.5rem;
        }

        label {
            display: block;
            font-size: .85rem;
            color: #9ca3af;
            margin-bottom: .25rem;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: .45rem .6rem;
            border-radius: .5rem;
            border: 1px solid #1f2937;
            background: #020617;
            color: #e5e7eb;
            margin-bottom: 1rem;
            font-size: .9rem;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input[type="file"] {
            margin-bottom: 1rem;
            font-size: .85rem;
        }

        .row {
            display: flex;
            gap: 1rem;
        }

        .row > div {
            flex: 1;
        }

        .btn {
            background: #22c55e;
            color: #022c22;
            padding: .5rem 1.4rem;
            border-radius: .5rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        .link {
            display: inline-block;
            margin-top: .75rem;
            font-size: .8rem;
            color: #9ca3af;
            text-decoration: none;
        }

        .error {
            color: #f97373;
            font-size: .75rem;
            margin-top: -.7rem;
            margin-bottom: .7rem;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: .4rem;
            margin-bottom: 1rem;
            font-size: .85rem;
            color: #cbd5f5;
        }
    </style>
</head>
<body>
<div class="page">
    <h1>Criar Evento</h1>

    <div class="card">
        <form method="POST"
              action="{{ route('admin.events.store') }}"
              enctype="multipart/form-data">
            @csrf

            <label for="title">Título do Evento</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title') <div class="error">{{ $message }}</div> @enderror

            <label for="description">Descrição</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror

            <div class="row">
                <div>
                    <label for="date">Data</label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}" required>
                    @error('date') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="start_time">Hora de Início</label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                    @error('start_time') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="end_time">Hora de Fim (opcional)</label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}">
                    @error('end_time') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div>
                    <label for="capacity">Capacidade extra (opcional)</label>
                    <input type="number" id="capacity" name="capacity" min="1" value="{{ old('capacity') }}">
                    @error('capacity') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="image">Cartaz / Imagem do evento (opcional)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" style="margin: 0;">Evento ativo (visível nas reservas)</label>
            </div>

            <button class="btn" type="submit">Guardar Evento</button>
        </form>

        <a href="{{ route('admin.events.index') }}" class="link">← Voltar à lista de eventos</a>
    </div>
</div>
</body>
</html>
