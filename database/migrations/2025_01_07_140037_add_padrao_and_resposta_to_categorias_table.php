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
        Schema::table('categorias', function (Blueprint $table) {
            $table->text('padrao')->nullable()->after('name'); // Adiciona o campo 'padrao' após o campo 'name'
            $table->text('resposta')->nullable()->after('padrao'); // Adiciona o campo 'resposta' após o campo 'padrao'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn('padrao'); // Remove o campo 'padrao'
            $table->dropColumn('resposta'); // Remove o campo 'resposta'
        });
    }
};
