<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('response_answers', function (Blueprint $table) {
            $table->text('answer_temp')->nullable(); // Nova coluna temporária
        });

        // Copiar dados da coluna antiga para a nova
        DB::statement('UPDATE response_answers SET answer_temp = answer');

        Schema::table('response_answers', function (Blueprint $table) {
            $table->dropColumn('answer'); // Remove a antiga
        });

        Schema::table('response_answers', function (Blueprint $table) {
            $table->renameColumn('answer_temp', 'answer'); // Renomeia para 'answer'
        });
    }

    public function down(): void
    {
        // Caso precise reverter
        Schema::table('response_answers', function (Blueprint $table) {
            $table->text('answer')->nullable(false); // Volta ao estado original
        });
    }
};
