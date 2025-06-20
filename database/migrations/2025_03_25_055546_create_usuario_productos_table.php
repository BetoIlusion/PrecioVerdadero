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
        Schema::create('usuario_productos', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio', 8, 2);
            $table->boolean('existe')->default(true);
            $table->unsignedBigInteger('id_usuario')->nullable(false);
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_estado');
            $table->timestamps();

            // Las claves foráneas se pueden agregar aquí directamente
            // $table->foreign('id_usuario')->references('id')->on('users');
            // $table->foreign('id_producto')->references('id')->on('productos');
            // $table->foreign('id_estado')->references('id')->on('estado_productos');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_productos');
    }
};
