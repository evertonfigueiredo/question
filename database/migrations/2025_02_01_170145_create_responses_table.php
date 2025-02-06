<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('response_answers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id'); // Identificador único do visitante
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('question_id'); // Para associar à pergunta
            $table->integer('answer'); // Resposta entre 1 e 5
            $table->timestamps();
    
            // Relacionamentos
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('response_answers');
    }
    
};
