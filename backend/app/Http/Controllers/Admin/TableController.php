<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // Listar mesas
    public function index()
    {
        $tables = Table::orderBy('name')->get();
        return view('admin.tables.index', compact('tables'));
    }

    // Form criar mesa
    public function create()
    {
        return view('admin.tables.create');
    }

    // Guardar nova mesa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'zone'     => 'required|string|max:50',
            'is_active'=> 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Table::create($validated);

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Mesa criada com sucesso!');
    }

    // Form editar mesa
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    // Atualizar mesa
    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'zone'     => 'required|string|max:50',
            'is_active'=> 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $table->update($validated);

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Mesa atualizada com sucesso!');
    }

    // Apagar mesa
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Mesa removida com sucesso!');
    }
}
