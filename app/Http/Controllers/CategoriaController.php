<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categorias = Categoria::paginate();

        return view('categoria.index', compact('categorias'))
            ->with('i', ($request->input('page', 1) - 1) * $categorias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categoria = new Categoria();

        return view('categoria.create', compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request): RedirectResponse
    {
        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'padrao' => 'required|string',
            'resposta' => 'required|string',
        ]);


        // Criação da categoria com o ID do usuário logado
        Categoria::create([
            'name' => $validatedData['name'],
            'padrao' => $validatedData['padrao'],
            'resposta' => $validatedData['resposta'],
            'user_id' => Auth::id(), // Aqui adiciona automaticamente o ID do usuário logado
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $categoria = Categoria::find($id);

        return view('categoria.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $categoria = Categoria::find($id);

        return view('categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validate([
            'name' => 'required|string|max:255',
            'padrao' => 'required|string',
            'resposta' => 'required|string',
        ]));

        return Redirect::route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id): RedirectResponse
    {
        Categoria::find($id)->delete();

        return Redirect::route('categorias.index')
            ->with('success', 'Categoria deletada com sucesso!');
    }
}
