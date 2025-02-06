<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseAnswer extends Model
{
    use HasFactory;

    // A tabela associada ao modelo
    protected $table = 'response_answers';

    // Atributos que podem ser preenchidos (Mass Assignment)
    protected $fillable = [
        'question_id', // Identificador da pergunta
        'answer',      // Resposta dada pelo usuário (1 a 5)
        'unique_id',      // Unique Id gerado dinamico
    ];

    // Relacionamento com a tabela Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    
}
