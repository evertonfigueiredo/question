@extends('layouts.app')

@section('template_title')
    {{ $categoria->name ?? __('Visualizar') . " " . __('Categoria') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Visualizar') }} Categoria</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('categorias.index') }}"> {{ __('Voltar') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $categoria->name }}
                                </div>

                                <div class="form-group mb-2 mb20">
                                    <strong>Padrão:</strong>
                                    {{ $categoria->padrao }}
                                </div>

                                <div class="form-group mb-2 mb20">
                                    <strong>Resposta Positiva:</strong>
                                    {{ $categoria->resposta }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
