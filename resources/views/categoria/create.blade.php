@extends('layouts.app')

@section('template_title')
    {{ __('Adicionar') }} Categoria
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Adicionar') }} Categoria</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('categorias.index') }}"> {{ __('Voltar') }}</a>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('categorias.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('categoria.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
