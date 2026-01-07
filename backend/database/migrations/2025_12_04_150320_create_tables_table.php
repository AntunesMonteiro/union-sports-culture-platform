<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('tables', function (Blueprint $table) {
        $table->id();

        // Nome/código da mesa (ex.: "M01", "Esplanada 3")
        $table->string('name');

        // Capacidade em nº de pessoas
        $table->unsignedTinyInteger('capacity')->default(2);

        // Zona da mesa
        $table->enum('zone', ['interior', 'esplanada', 'palco', 'outro'])
              ->default('interior');

        // Se a mesa está ativa
        $table->boolean('is_active')->default(true);

        // Notas livres
        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
