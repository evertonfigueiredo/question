@extends('layouts.blank') <!-- Layout sem cabeçalho, barra lateral, etc. -->

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
            <h1 class="text-3xl font-bold mb-4">{{ $survey->title }}</h1>
            <p class="text-gray-600">{!! nl2br(e($survey->description)) !!}</p>

            <div class="flex justify-end">
                <a href="{{ route('survey.public.start', ['slug' => $survey->slug]) }}"
                    class="mt-4 inline-block px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Responder à Pesquisa
                </a>

            </div>
        </div>
    </div>
@endsection
