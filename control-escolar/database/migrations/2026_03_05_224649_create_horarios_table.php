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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained();
            $table->foreignId('materia_id')->constrained();
            //$table->string('dia');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });
    }

    //Cada usuario se registra

    /**
     * Reverse the migrations.
     * php artisan serve
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};

