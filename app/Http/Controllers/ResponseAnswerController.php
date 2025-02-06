<?php

namespace App\Http\Controllers;

use App\Models\ResponseAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ResponseAnswerRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ResponseAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $surveyId = $request->query('survey_id');


        if (!$surveyId) {
            return redirect()->route('surveys.index'); // Redireciona para /surveys
        }

        $query = ResponseAnswer::query();

        if ($surveyId) {
            $query->where('survey_id', $surveyId);
        }

        $responseAnswers = $query->paginate();
        $groupedByUniqueId = $responseAnswers->getCollection()->groupBy('unique_id');

        $groupedByUniqueId = $groupedByUniqueId->map(function ($responses) {
            // Pega o survey_id da primeira resposta, que deve ser o mesmo para todas
            $survey_id = $responses->first()->survey_id;

            $questionCount = Question::where('survey_id', $survey_id)->count();
            
            // Conta quantas perguntas únicas foram respondidas
            $answeredQuestionsCount = $responses->pluck('question_id')->unique()->count();
    
            return [
                'survey_id' => $survey_id, // Adiciona o survey_id ao grupo
                'responses' => $responses,
                'answeredQuestionsCount' => $answeredQuestionsCount,
                'questionCount' => $questionCount
            ];
        });


        return view('response-answer.index', compact('responseAnswers', 'groupedByUniqueId', 'surveyId'))
            ->with('i', ($request->input('page', 1) - 1) * $responseAnswers->perPage());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $responseAnswer = new ResponseAnswer();

        return view('response-answer.create', compact('responseAnswer'));
    }

    /**
     * Display the specified resource.
     */
    public function show($unique_id): View
    {
        // Busca todas as respostas com o mesmo unique_id
        $responseAnswers = ResponseAnswer::where('unique_id', $unique_id)->with('question')->get();

        // Verifica se há respostas para evitar erro na view
        if ($responseAnswers->isEmpty()) {
            abort(404, 'Nenhuma resposta encontrada para este ID.');
        }
    
        return view('response-answer.show', compact('responseAnswers', 'unique_id'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $responseAnswer = ResponseAnswer::find($id);

        return view('response-answer.edit', compact('responseAnswer'));
    }



    public function destroy($id): RedirectResponse
    {
        ResponseAnswer::find($id)->delete();

        return Redirect::route('response-answers.index')
            ->with('success', 'ResponseAnswer deleted successfully');
    }
}
