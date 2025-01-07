@extends('layouts.app')

@section('template_title')
    {{ $pergunta->name ?? __('Visualizar') . " " . __('Pergunta') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Visualizar') }} Pergunta</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('perguntas.index') }}"> {{ __('Voltar') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Pergunta:</strong>
                                    {{ $pergunta->pergunta }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Categoria:</strong>
                                    {{ $pergunta->categoria->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Pergunta:</strong>
                                    {{ $pergunta->tipo == 'N' ? 'Negativa' : 'Positiva' }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
