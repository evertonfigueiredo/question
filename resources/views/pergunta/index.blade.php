@extends('layouts.app')

@section('template_title')
    Perguntas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Perguntas') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('perguntas.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Adicionar Pergunta') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>Nº</th>

                                        <th>Pergunta</th>
                                        <th>Categoria</th>
                                        <th>Tipo</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perguntas as $pergunta)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $pergunta->pergunta }}</td>
                                            <td>{{ $pergunta->categoria->name }}</td>
                                            <td>{{ $pergunta->tipo == 'N' ? 'Negativa' : 'Positiva'  }}</td>

                                            <td>
                                                <form action="{{ route('perguntas.destroy', $pergunta->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('perguntas.show', $pergunta->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Visualizar') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('perguntas.edit', $pergunta->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); confirm('Você deseja deletar essa pergunta?') ? this.closest('form').submit() : false;"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Deletar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $perguntas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
