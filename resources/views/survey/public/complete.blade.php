@extends('layouts.blank')

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
            <h1 class="text-3xl font-bold mb-4">Obrigado por completar a pesquisa!</h1>
            <p class="text-gray-600">Sua participação foi registrada com sucesso.</p>
            <img src="{{ asset('final.jpeg') }}"  alt="">
        </div>
    </div>
@endsection
