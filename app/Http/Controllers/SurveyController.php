<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SurveyRequest;
use App\Models\Question;
use App\Models\ResponseAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        if (Auth::id() === 1) {
            $surveys = Survey::paginate();
        } else {
            $surveys = Survey::where('user_id', Auth::id())->paginate();
        }



        return view('survey.index', compact('surveys'))
            ->with('i', ($request->input('page', 1) - 1) * $surveys->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $survey = new Survey();

        return view('survey.create', compact('survey'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SurveyRequest $request): RedirectResponse
    {
        // Gerar o slug automaticamente com base no título da pesquisa
        $slug = Str::slug($request->title);

        // Criar a pesquisa com o slug
        Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $slug, // Adicionando o slug
            'user_id' => Auth::id()
        ]);

        return Redirect::route('surveys.index')
            ->with('success', 'Survey created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $survey = Survey::findOrFail($id);
        $questions = $survey->questions()->paginate(10);

        return view('survey.show', compact('survey', 'questions'));
    }

    // Método para exibir a pesquisa pública
    public function showPublic($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        return view('survey.public.show', compact('survey'));
    }

    public function startSurvey($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();

        // Criar um ID único para a sessão do usuário
        $uniqueId = uniqid();  // Pode usar outra abordagem, como cookies, para garantir que o ID seja persistente

        // Salvar o ID único na sessão ou armazenar de forma que possa ser usado nas respostas
        session(['unique_id' => $uniqueId, 'survey_id' => $survey->id]);

        // Redirecionar para a primeira pergunta
        return redirect()->route('survey.public.answer', ['slug' => $slug, 'question_id' => $survey->questions->first()->id]);
    }

    public function showQuestion($slug, $question_id)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $question = Question::findOrFail($question_id);

        // Verificar se o usuário já respondeu essa pergunta
        $uniqueId = session('unique_id');
        $existingResponse = ResponseAnswer::where('survey_id', $survey->id)
        ->where('question_id', $question->id)
        ->where('unique_id', $uniqueId)
        ->first();


        // Atualiza o histórico de perguntas
        $history = session('question_history', []);

        // Adiciona ao histórico apenas se ainda não estiver lá
        if (!in_array($question->id, $history)) {
            $history[] = $question->id;
            session(['question_history' => $history]);
        }

        return view('survey.public.answer', compact('survey', 'question', 'existingResponse'));
    }

    public function nextQuestion($survey, $currentQuestion, $uniqueId)
    {
        $nextQuestion = $survey->questions()
            ->where('id', '>', $currentQuestion->id)
            ->first();

        // Se não houver próxima pergunta, finalizar a pesquisa
        if (!$nextQuestion) {
            return redirect()->route('survey.public.complete', $survey->slug);
        }

        // Atualiza o histórico de perguntas
        $history = session('question_history', []);

        // Adiciona ao histórico apenas se ainda não estiver lá
        if (!in_array($nextQuestion->id, $history)) {
            $history[] = $nextQuestion->id;
            session(['question_history' => $history]);
        }

        return redirect()->route('survey.public.answer', ['slug' => $survey->slug, 'question_id' => $nextQuestion->id]);
    }

    public function storeResponse(Request $request, $slug, $question_id)
    {
        // Recupera a pesquisa e a pergunta
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $question = Question::findOrFail($question_id);

        // Verifica se o usuário já respondeu a esta pergunta
        $responseAnswer = ResponseAnswer::where('question_id', $question->id)
            ->where('survey_id', $survey->id)
            ->where('unique_id', session('unique_id'))
            ->first();

        if ($responseAnswer) {
            // Se já respondeu, apenas atualiza a resposta
            $responseAnswer->answer = $request->answer ?? 'Usuário não respondeu!';
            $responseAnswer->save();
        } else {
            // Caso contrário, cria uma nova resposta
            $responseAnswer = new ResponseAnswer();
            $responseAnswer->question_id = $question->id;
            $responseAnswer->survey_id = $survey->id;
            $responseAnswer->answer = $request->answer ?? 'Usuário não respondeu!';
            $responseAnswer->unique_id = session('unique_id');
            $responseAnswer->save();
        }

        // Atualiza o histórico de perguntas respondidas
        $history = session('question_history', []);

        // Adiciona ao histórico apenas se ainda não estiver lá
        if (!in_array($question->id, $history)) {
            $history[] = $question->id;
            session(['question_history' => $history]);
        }

        // Redireciona para a próxima pergunta
        return $this->nextQuestion($survey, $question, session('unique_id'));
    }

    public function previousQuestion($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        $history = session('question_history', []);

        if (count($history) > 1) {
            // Remove a última pergunta do histórico (a pergunta atual)
            array_pop($history);

            // Obtém a nova última pergunta do histórico (a pergunta anterior)
            $previousQuestionId = end($history);

            // Atualiza a sessão com o histórico atualizado
            session(['question_history' => $history]);

            // Redireciona para a pergunta anterior
            $url = url("/surveys/slug/{$survey->slug}/question/{$previousQuestionId}");
            return redirect($url);
        }

        // Se não houver histórico suficiente, redireciona para a primeira pergunta
        $url = url("/surveys/slug/{$survey->slug}/question/{$survey->questions()->first()->id}");
        return redirect($url);
    }


    public function completeSurvey($slug)
    {
        return view('survey.public.complete', compact('slug'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $survey = Survey::find($id);

        return view('survey.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SurveyRequest $request, Survey $survey): RedirectResponse
    {
        $survey->update($request->validated());

        return Redirect::route('surveys.index')
            ->with('success', 'Survey updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Survey::find($id)->delete();

        return Redirect::route('surveys.index')
            ->with('success', 'Survey deleted successfully');
    }


    public function export($id)
    {

        // Cria uma nova instância do Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define os cabeçalhos das colunas
        $sheet->setCellValue('A1', 'ID da Pesquisa');
        $sheet->setCellValue('B1', 'Título da Pesquisa');
        $sheet->setCellValue('C1', 'Descrição da Pesquisa');
        $sheet->setCellValue('D1', 'Pergunta');
        $sheet->setCellValue('E1', 'Resposta');
        $sheet->setCellValue('F1', 'Usuário');
        $sheet->setCellValue('G1', 'Data da Resposta');

        // Busca os dados das pesquisas e respostas
        if (Auth::id() === 1) {
            $surveys = Survey::with(['questions.answers'])->findOrFail($id)->get();
        } else {
            $surveys = Survey::where('user_id', Auth::id())->with(['questions.answers'])->findOrFail($id)->get();
        }



        $survey = $surveys->find($id);


        // Preenche os dados na planilha
        $row = 2; // Começa na linha 2 (abaixo dos cabeçalhos)

        foreach ($survey->questions as $question) {
            foreach ($question->answers as $answer) {
                $sheet->setCellValue('A' . $row, $survey->id);
                $sheet->setCellValue('B' . $row, $survey->title);
                $sheet->setCellValue('C' . $row, $survey->description);
                $sheet->setCellValue('D' . $row, $question->content);
                $sheet->setCellValue('E' . $row, $answer->answer);
                $sheet->setCellValue('F' . $row, $answer->unique_id); // Ou $answer->user->name se tiver relacionamento com User
                $sheet->setCellValue('G' . $row, $answer->created_at->format('d/m/Y H:i:s'));
                $row++;
            }
        }




        // ---------------

        // Agora, após o foreach, ordenando as linhas na planilha
        // Assumindo que os dados começam na linha 2, e que as colunas são A a G
        $highestRow = $sheet->getHighestRow(); // Última linha preenchida
        $highestColumn = 'G'; // Coluna até onde os dados vão (G no caso)

        $data = [];
        // Coleta todos os dados
        for ($row = 2; $row <= $highestRow; $row++) {
            $data[] = [
                'survey_id' => $sheet->getCell('A' . $row)->getValue(),
                'survey_title' => $sheet->getCell('B' . $row)->getValue(),
                'survey_description' => $sheet->getCell('C' . $row)->getValue(),
                'question_content' => $sheet->getCell('D' . $row)->getValue(),
                'answer' => $sheet->getCell('E' . $row)->getValue(),
                'unique_id' => $sheet->getCell('F' . $row)->getValue(),
                'created_at' => $sheet->getCell('G' . $row)->getValue(),
            ];
        }

        // Ordenar os dados coletados pela coluna 'unique_id'
        usort($data, function ($a, $b) {
            return $a['unique_id'] <=> $b['unique_id'];
        });

        // Reescrever os dados ordenados de volta para a planilha
        $row = 2; // Começar a preencher as células novamente
        foreach ($data as $rowData) {
            $sheet->setCellValue('A' . $row, $rowData['survey_id']);
            $sheet->setCellValue('B' . $row, $rowData['survey_title']);
            $sheet->setCellValue('C' . $row, $rowData['survey_description']);
            $sheet->setCellValue('D' . $row, $rowData['question_content']);
            $sheet->setCellValue('E' . $row, $rowData['answer']);
            $sheet->setCellValue('F' . $row, $rowData['unique_id']);
            $sheet->setCellValue('G' . $row, $rowData['created_at']);
            $row++;
        }

        // -----------

        // Cria um writer para exportar o arquivo
        $writer = new Xlsx($spreadsheet);

        // Define o nome do arquivo
        $fileName = 'surveys_' . now()->format('Ymd_His') . '.xlsx';

        // Retorna o arquivo para download
        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
