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
        Schema::table('perguntas', function (Blueprint $table) {
            $table->enum('tipo', ['P', 'N'])->default('P')->after('categoria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perguntas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
