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
        Schema::create('estado_productos', function (Blueprint $table) {
            $table->id();
            // Para fechas en Laravel se usa timestamp o dateTime
            // Se guarda automáticamente en formato Y-m-d H:i:s (ej: 2025-03-24 15:30:00)
            $table->string('estado_producto')->unique();
            $table->timestamp('updated_date')->useCurrent();
            // $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_productos');
    }
};
