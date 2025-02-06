<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function storeResponse(Request $request, $surveySlug)
    {
        // Recupera a pesquisa usando o slug
        $survey = Survey::where('slug', $surveySlug)->firstOrFail();

        // Gera um ID único para o visitante (usando o IP ou algo mais específico)
        $uniqueId = $request->ip();  // Pode usar uma abordagem mais sofisticada para garantir unicidade

        // Armazena as respostas para cada pergunta diretamente na tabela response_answers
        foreach ($survey->questions as $question) {
            // Cria a resposta para cada pergunta
            ResponseAnswer::create([
                'unique_id' => $uniqueId,
                'survey_id' => $survey->id,
                'question_id' => $question->id,
                'answer' => $request->input('question_' . $question->id), // Recebe as respostas da requisição
            ]);
        }

        return redirect()->route('survey.public.show', $survey->slug)->with('success', 'Your responses have been recorded!');
    }
}
