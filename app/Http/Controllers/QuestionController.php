<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Models\QuestionOption;
use App\Models\Survey;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questions = Question::paginate();

        return view('question.index', compact('questions'))
            ->with('i', ($request->input('page', 1) - 1) * $questions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        // $question = new Question();

        // return view('question.create', compact('question'));

        // Recebe o survey_id da URL
        $surveyId = $request->query('survey_id');

        // Passa o survey_id para a view
        return view('question.create', [
            'survey_id' => $surveyId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'type' => 'required|string|in:radio,open,multiple',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
        ]);

        $question = Question::create([
            'content' => $request->content,
            'survey_id' => $request->survey_id,
            'type' => $request->type,
        ]);

        if ($request->type === 'multiple' && $request->has('options')) {
            foreach ($request->options as $option) {
                if (!empty($option)) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                    ]);
                }
            }
        }

        return redirect()->route('surveys.show', ['id' => $request->survey_id])
        ->with('success', 'Pergunta criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $question = Question::find($id);

        return view('question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $question = Question::find($id);

        return view('question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        $question = Question::findOrFail($question->id);

        $request->validate([
            'content' => 'required|string|max:255',
            'type' => 'required|in:radio,open,multiple',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string|max:255',
        ]);

        // Atualiza os dados da pergunta
        $question->update([
            'content' => $request->content,
            'type' => $request->type,
        ]);
       
        // Se for múltipla escolha, atualiza as opções
        if ($request->type === 'multiple') {
            $question->options()->delete(); // Remove opções antigas
            foreach ($request->options as $option) {
                if (!empty($option)) {
                    $question->options()->create(['option_text' => $option]);
                }
            }
        }

        return redirect()->route('questions.index')
            ->with('success', 'Pergunta atualizada com sucesso!');
    }

    public function destroy($id): RedirectResponse
    {
        $question = Question::find($id);
        Question::find($id)->delete();

        return Redirect::route('surveys.show', $question->survey_id)
            ->with('success', 'Question deleted successfully!');
    }
}
