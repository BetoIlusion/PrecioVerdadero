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
        Schema::create('historial_productos', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio', 8, 2);
            $table->date('fecha');
            $table->dateTime('fecha_hora');
            $table->unsignedBigInteger('id_usuario_producto');
            $table->unsignedBigInteger('id_estado_producto');
            $table->foreign('id_usuario_producto')->references('id')->on('usuario_productos')->onDelete('cascade');
$table->foreign('id_estado_producto')->references('id')->on('estado_productos')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_productos');
    }
};
