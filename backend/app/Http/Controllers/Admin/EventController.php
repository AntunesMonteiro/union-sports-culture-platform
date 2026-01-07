<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EventController extends Controller
{
    // Lista de eventos
    public function index()
    {
        $events = Event::orderBy('date', 'desc')
            ->orderBy('start_time')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    // Formulário de criação
    public function create()
    {
        return view('admin.events.create');
    }

    // Guardar novo evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'nullable',
            'capacity'    => 'nullable|integer|min:1',
            'image'       => 'nullable|image|max:2048', // 2MB
        ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('events', 'public');
    }

    // Slug único com base no título + timestamp
    $slug = Str::slug($validated['title']) . '-' . now()->format('YmdHis');

    Event::create([
        'title'       => $validated['title'],
        'slug'        => $slug,
        'description' => $validated['description'] ?? null,
        'date'        => $validated['date'],
        'start_time'  => $validated['start_time'],
        'end_time'    => $validated['end_time'] ?? null,
        'capacity'    => $validated['capacity'] ?? null,
        'image_path'  => $imagePath,
        'is_active'   => $request->has('is_active'),
        'created_by'  => auth()->id(),
    ]);


        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    // Form de edição
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // Atualizar evento
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'nullable',
            'capacity'    => 'nullable|integer|min:1',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = [
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'date'        => $validated['date'],
            'start_time'  => $validated['start_time'],
            'end_time'    => $validated['end_time'] ?? null,
            'capacity'    => $validated['capacity'] ?? null,
            'is_active'   => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // apagar anterior se existir
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    // Apagar evento
    public function destroy(Event $event)
    {
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento removido com sucesso!');
    }
}
