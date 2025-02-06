<?php

namespace App\Http\Controllers;

use App\Models\QuestionOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionOptionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionOptions = QuestionOption::paginate();

        return view('question-option.index', compact('questionOptions'))
            ->with('i', ($request->input('page', 1) - 1) * $questionOptions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionOption = new QuestionOption();

        return view('question-option.create', compact('questionOption'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionOptionRequest $request): RedirectResponse
    {
        QuestionOption::create($request->validated());

        return Redirect::route('question-options.index')
            ->with('success', 'QuestionOption created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionOption = QuestionOption::find($id);

        return view('question-option.show', compact('questionOption'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionOption = QuestionOption::find($id);

        return view('question-option.edit', compact('questionOption'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionOptionRequest $request, QuestionOption $questionOption): RedirectResponse
    {
        $questionOption->update($request->validated());

        return Redirect::route('question-options.index')
            ->with('success', 'QuestionOption updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        QuestionOption::find($id)->delete();

        return Redirect::route('question-options.index')
            ->with('success', 'QuestionOption deleted successfully');
    }
}
