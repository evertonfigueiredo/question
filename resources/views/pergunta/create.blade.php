@extends('layouts.app')

@section('template_title')
    {{ __('Adicionar') }} Pergunta
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Adicionar') }} Pergunta</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('perguntas.index') }}"> {{ __('Voltar') }}</a>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('perguntas.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('pergunta.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
