@extends('layouts.blank')

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
            {{-- <h1 class="text-2xl font-bold mb-4">{{ $survey->title }}</h1> --}}

            <form
                action="{{ route('survey.public.storeResponse', ['slug' => $survey->slug, 'question_id' => $question->id]) }}"
                method="POST">
                @csrf
                <div>

                    <div>{!! nl2br($question->content) !!}</div>
                    <br>

                    <!-- Exibir diferentes tipos de resposta -->
                    @if ($question->type === 'radio')
                        <!-- Resposta Simples (Radio Buttons) -->
                        <div class="flex justify-center space-x-2">
                            <label for="1">
                                <input type="radio" required name="answer" id="1" value="1"
                                    class="hidden peer" />
                                <img src="{{ asset('1.png') }}" alt="1"
                                    class="w-9 h-9 opacity-50 peer-checked:opacity-100 cursor-pointer" />
                            </label>
                            <label for="2">
                                <input type="radio" required name="answer" id="2" value="2"
                                    class="hidden peer" />
                                <img src="{{ asset('2.png') }}" alt="2"
                                    class="w-9 h-9 opacity-50 peer-checked:opacity-100 cursor-pointer" />
                            </label>
                            <label for="3">
                                <input type="radio" required name="answer" id="3" value="3"
                                    class="hidden peer" />
                                <img src="{{ asset('3.png') }}" alt="3"
                                    class="w-9 h-9 opacity-50 peer-checked:opacity-100 cursor-pointer" />
                            </label>
                            <label for="4">
                                <input type="radio" required name="answer" id="4" value="4"
                                    class="hidden peer" />
                                <img src="{{ asset('4.png') }}" alt="4"
                                    class="w-9 h-9 opacity-50 peer-checked:opacity-100 cursor-pointer" />
                            </label>
                            <label for="5">
                                <input type="radio" required name="answer" id="5" value="5"
                                    class="hidden peer" />
                                <img src="{{ asset('5.png') }}" alt="5"
                                    class="w-9 h-9 opacity-50 peer-checked:opacity-100 cursor-pointer" />
                            </label>
                        </div>

                        <div class="mt-10 text-xs text-gray-700">
                            <p class="my-3">Legenda: </p>
                            <div class="flex flex-col space-y-2"> <!-- Alinhamento vertical -->
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('1.png') }}" alt="1" class="w-6 h-6 grayscale" />
                                    <span>Discordo totalmente</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('2.png') }}" alt="2" class="w-6 h-6 grayscale" />
                                    <span>Discordo</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('3.png') }}" alt="3" class="w-6 h-6 grayscale"  />
                                    <span>Não concordo e nem discordo</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('4.png') }}" alt="4" class="w-6 h-6 grayscale" />
                                    <span>Concordo</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('5.png') }}" alt="5" class="w-6 h-6 grayscale" />
                                    <span>Concordo totalmente</span>
                                </div>
                            </div>
                        </div>
                        
                    @elseif($question->type === 'multiple')
                        <!-- Resposta de Múltipla Escolha (Opções dinâmicas) -->
                        <div>
                            @foreach ($question->options as $option)
                                <div>
                                    <input type="radio" required name="answer" id="option_{{ $option->id }}"
                                        value="{{ $option->option_text }}" class="mr-2" />
                                    <label for="option_{{ $option->id }}">{{ $option->option_text }}</label>
                                </div>
                            @endforeach
                        </div>
                    @elseif($question->type === 'open')
                        <!-- Resposta Aberta (Campo de texto) -->
                        <textarea name="answer" {{ $question->required ? 'required' : '' }} rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Digite sua resposta..."></textarea>
                    @endif
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="mt-4 inline-block px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Próximo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
