<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // hasColumn para evitar erros de "duplicate column"
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (!Schema::hasColumn('events', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }

            if (!Schema::hasColumn('events', 'capacity')) {
                $table->integer('capacity')->nullable()->after('end_time');
            }

            if (!Schema::hasColumn('events', 'image_path')) {
                $table->string('image_path')->nullable()->after('capacity');
            }

            if (!Schema::hasColumn('events', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image_path');
            }

            if (!Schema::hasColumn('events', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // proteger no down com hasColumn para evitar erros
            if (Schema::hasColumn('events', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('events', 'end_time')) {
                $table->dropColumn('end_time');
            }
            if (Schema::hasColumn('events', 'capacity')) {
                $table->dropColumn('capacity');
            }
            if (Schema::hasColumn('events', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (Schema::hasColumn('events', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('events', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
    }
};
