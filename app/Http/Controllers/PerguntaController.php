<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PerguntaRequest;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PerguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $perguntas = Pergunta::with('categoria')->paginate();

        return view('pergunta.index', compact('perguntas'))
            ->with('i', ($request->input('page', 1) - 1) * $perguntas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categorias = Categoria::where('user_id', Auth::id())->get(); // Busca as categorias do usuário logado
        $pergunta = new Pergunta();

        return view('pergunta.create', compact('categorias', 'pergunta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerguntaRequest $request): RedirectResponse
    {
        // Adiciona o ID do usuário autenticado nos dados do request
        $data = $request->validated(); // Dados validados pelo PerguntaRequest
        $data['user_id'] = Auth::id(); // Adiciona o ID do usuário logado
        
        // Cria a pergunta com os dados
        Pergunta::create($data);

        // Redireciona com mensagem de sucesso
        return Redirect::route('perguntas.index')
            ->with('success', 'Pergunta criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pergunta = Pergunta::find($id);
        $categorias = Categoria::where('user_id', Auth::id())->get(); // Busca as categorias do usuário logado

        return view('pergunta.show', compact('categorias', 'pergunta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pergunta = Pergunta::find($id);
        $categorias = Categoria::where('user_id', Auth::id())->get(); // Busca as categorias do usuário logado

        return view('pergunta.edit', compact('categorias', 'pergunta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerguntaRequest $request, Pergunta $pergunta): RedirectResponse
    {
        $pergunta->update($request->validated());

        return Redirect::route('perguntas.index')
            ->with('success', 'Pergunta atualizada com sucesso!');
    }

    public function destroy($id): RedirectResponse
    {
        Pergunta::find($id)->delete();

        return Redirect::route('perguntas.index')
            ->with('success', 'Pergunta deletada com sucesso!');
    }
}
