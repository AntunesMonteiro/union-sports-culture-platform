<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Já existe a coluna "role" em users.
        // Migration vazia só para marcar como executada.
    }

    public function down(): void
    {
        // Não remover a coluna.
    }
};
