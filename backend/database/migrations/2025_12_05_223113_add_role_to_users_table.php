<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Já existe a coluna "role" em users.
        // Esta migration fica vazia só para marcar como executada.
    }

    public function down(): void
    {
        // Não fazemos nada no down porque não queremos remover a coluna.
    }
};
