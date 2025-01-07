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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id(); // ID único da categoria
            $table->foreignId('user_id') // Relacionamento com o usuário
                ->constrained() // Constrói a foreign key automaticamente com a tabela 'users'
                ->onDelete('cascade'); // Remove as categorias se o usuário for deletado
            $table->string('name'); // Nome da categoria
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
