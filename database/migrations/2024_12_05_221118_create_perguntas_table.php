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
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id();
            $table->string('pergunta');
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onDelete('cascade'); // Apaga as perguntas se a categoria for apagada
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Apaga as perguntas se o usuário for apagado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perguntas');
    }
};
