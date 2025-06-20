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
            $table->string('marca')->nullable();
            $table->boolean('disponibilidad')->default(true);
            //$table->boolean('estado')->default(true);

            $table->unsignedBigInteger('id_unidad')->nullable();
            $table->unsignedBigInteger('id_sub_tipo')->nullable();
            $table->timestamps();
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
