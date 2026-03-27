<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('tareas', 'maestro_id')) {
            Schema::table('tareas', function (Blueprint $table) {
                $table->foreignId('maestro_id')->nullable()->after('grupo_id')->constrained('users')->cascadeOnDelete();
            });
        }

        // Copiar valores existentes si existe created_by (compatibilidad con datos previos)
        if (Schema::hasColumn('tareas', 'created_by')) {
            \DB::table('tareas')->update(['maestro_id' => \DB::raw('created_by')]);
        }

        // Hacer obligatorio luego de la migración de datos
        if (Schema::hasColumn('tareas', 'maestro_id')) {
            Schema::table('tareas', function (Blueprint $table) {
                $table->foreignId('maestro_id')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropForeign(['maestro_id']);
            $table->dropColumn('maestro_id');
        });
    }
};
