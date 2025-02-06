<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('content'); // Conteúdo da pergunta
            $table->unsignedBigInteger('survey_id'); // Chave estrangeira
            $table->timestamps(); // created_at e updated_at

            // Definindo a chave estrangeira
            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
                  ->onDelete('cascade'); // Se uma pesquisa for deletada, suas perguntas também serão
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}