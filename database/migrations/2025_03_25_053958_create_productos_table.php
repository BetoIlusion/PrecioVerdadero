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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('marca');
            $table->boolean('disponibilidad')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_');
            // Definir las relaciones foráneas
            // $table->foreign('id_unidad')->references('id')->on('unidades')->onDelete('cascade');
            // $table->foreign('id_tipo')->references('id')->on('tipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
