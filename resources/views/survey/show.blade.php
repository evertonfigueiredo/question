<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $survey->title ?? __('Visualizar') . ' ' . __('Pesquisa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Detalhes') }} da Pesquisa
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">Aqui você visualiza todos os detalhes da sua pesquisa.
                            </p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex space-x-4">
                            <!-- Botão Visualizar Respostas -->
                            <a type="button" href="{{ route('response-answers.index', ['survey_id' => $survey->id]) }}"
                                class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                Visualizar Respostas
                            </a>

                            <a href="{{ route('surveys.export', $survey->id) }}"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                Exportar Relatório
                            </a>

                            <!-- Botão Back -->
                            <a type="button" href="{{ route('surveys.index') }}"
                                class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Voltar
                            </a>
                        </div>

                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="mt-6 border-t border-gray-100">
                                    <dl class="divide-y divide-gray-100">

                                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Título</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                {{ $survey->title }}</dd>
                                        </div>
                                        
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Link</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                <button
                                                    onclick="copyToClipboard('{{ url('/surveys/slug/' . $survey->slug) }}')"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    {{ url('/surveys/slug/' . $survey->slug) }}
                                                </button>
                                            </dd>
                                        </div>

                                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Descrição da
                                                Pesquisa</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                {!! nl2br(e($survey->description)) !!}</dd>
                                        </div>



                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="py-10">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Perguntas') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Lista de Perguntas que contem essa pesquisa.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="{{ route('questions.create', ['survey_id' => $survey->id]) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Adicionar Perguntas') }}
                            </a>
                        </div>
                    </div>
                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Nº</th>

                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Pergunta</th>

                                            <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach ($questions as $question)
                                            <tr class="even:bg-gray-50">
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                                                    {{ $loop->iteration }}</td>

                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ $question->content }}</td>

                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                    <form action="{{ route('questions.destroy', $question->id) }}"
                                                        method="POST">
                                                        <a href="{{ route('questions.show', $question->id) }}"
                                                            class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Visualizar') }}</a>
                                                        <a href="{{ route('questions.edit', $question->id) }}"
                                                            class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Editar') }}</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('questions.destroy', $question->id) }}"
                                                            class="text-red-600 font-bold hover:text-red-900"
                                                            onclick="event.preventDefault(); confirm('Tem certeza que deseja deletar?') ? this.closest('form').submit() : false;">{{ __('Deletar') }}</a>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $questions->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            // Cria um elemento temporário de input
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);

            // Seleciona o texto e executa o comando de cópia
            input.select();
            document.execCommand('copy');

            // Remove o input temporário
            document.body.removeChild(input);

            // Exibe uma mensagem de sucesso
            alert('Link copiado para a área de transferência!');
        }
    </script>
</x-app-layout>
