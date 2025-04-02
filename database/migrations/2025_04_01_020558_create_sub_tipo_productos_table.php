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
        Schema::create('sub_tipo_productos', function (Blueprint $table) {
            $table->id();
            $table->string('sub_tipo');
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('id_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sup_tipo_productos');
    }
};
