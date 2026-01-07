<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();

        // Cliente associado à reserva 
        $table->foreignId('user_id')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        // Dados do cliente (mesmo sem conta)
        $table->string('customer_name');
        $table->string('customer_phone', 20)->nullable();
        $table->string('customer_email')->nullable();

        // Mesa (pode ser null em reservas de evento genéricas)
        $table->foreignId('table_id')
              ->nullable()
              ->constrained('tables')
              ->nullOnDelete();

        // Evento (pode ser null em reservas normais)
        $table->foreignId('event_id')
              ->nullable()
              ->constrained('events')
              ->nullOnDelete();

        // Data / hora da reserva
        $table->date('date');
        $table->time('time');

        // Nº de pessoas
        $table->unsignedTinyInteger('num_people')->default(2);

        // Estado da reserva
        $table->enum('status', [
            'pending',
            'confirmed',
            'seated',
            'cancelled',
            'no_show',
        ])->default('pending');

        // De onde veio a reserva
        $table->enum('source', [
            'website',
            'phone',
            'walk_in',
            'other',
        ])->default('website');

        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
