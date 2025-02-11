<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesquisas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Pesquisas') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Todas as suas pesquisas.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('surveys.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Criar Pesquisa</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nº</th>
                                        
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Título</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Link</th>

                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        
                                    @foreach ($surveys as $survey)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                            
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500  max-w-xs truncate">{{ $survey->title }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500  max-w-xs truncate">
                                            <button onclick="copyToClipboard('{{ url('/surveys/slug/'.$survey->slug) }}')" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $survey->slug }}
                                            </button>
                                        </td>

                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST">
                                                    <a href="{{ route('surveys.show', $survey->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Visualizar') }}</a>
                                                    <a href="{{ route('surveys.edit', $survey->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('surveys.destroy', $survey->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('Tem certeza que deseja deletar a sua pesquisa?') ? this.closest('form').submit() : false;">{{ __('Deletar') }}</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $surveys->withQueryString()->links() !!}
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