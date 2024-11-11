<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tenis', function (Blueprint $table) {
            $table->id();
            $table->string('model', 100); // Modelo del tenis
            $table->string('marca', 50); // Marca del tenis
            $table->string('color', 50); // Color principal
            $table->decimal('precio', 8, 2); // Precio
            $table->smallInteger('talla'); // Talla del tenis
            $table->string('material', 50); // Material principal
            $table->string('categoria', 50); // Categoría (deportivo, casual, etc.)
            $table->string('image', 100)->nullable(); // Permitir valores nulos
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenis');
    }
};
