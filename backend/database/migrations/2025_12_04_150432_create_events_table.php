<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->string('slug')->unique(); // URLs amigáveis
        $table->text('description')->nullable();

        $table->date('date');
        $table->time('start_time');
        $table->time('end_time')->nullable();

        // Capacidade máxima do evento (se aplicável)
        $table->unsignedInteger('max_guests')->nullable();

        // Se é público no site
        $table->boolean('is_public')->default(true);

        // Estado do evento
        $table->enum('status', ['draft', 'published', 'cancelled'])
              ->default('draft');

        // Quem criou o evento
        $table->foreignId('created_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
