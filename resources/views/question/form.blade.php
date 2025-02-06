<div class="space-y-6">
    <div>
        <x-input-label for="content" :value="__('Pergunta')" />
        <x-text-input id="content" name="content" type="text" class="mt-1 block w-full" :value="old('content', $question->content ?? '')"
            autocomplete="content" placeholder="Digite aqui sua pergunta para adicionar à pesquisa." />
        <x-input-error class="mt-2" :messages="$errors->get('content')" />
    </div>

    <!-- Campo oculto para o survey_id -->
    <input type="hidden" name="survey_id" value="{{ $survey_id ?? $question->survey->id }}" />

    <!-- Seleção do tipo de pergunta -->
    <div>
        <x-input-label for="type" :value="__('Tipo da Pergunta')" />
        <select id="type" name="type" onchange="toggleOptions()"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="radio" {{ old('type', $question->type ?? '') === 'radio' ? 'selected' : '' }}>Resposta
                Simples</option>
            <option value="open" {{ old('type', $question->type ?? '') === 'open' ? 'selected' : '' }}>Aberta</option>
            <option value="multiple" {{ old('type', $question->type ?? '') === 'multiple' ? 'selected' : '' }}>Múltipla
                Escolha</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('type')" />
    </div>

    <!-- Campo de opções para múltipla escolha (inicialmente oculto) -->
    <div id="multiple-options" style="display: none;">
        <x-input-label :value="__('Opções de Resposta')" />
        <div id="options-container">
            @if (isset($question) && $question->type === 'multiple' && $question->options->isNotEmpty())
                @foreach ($question->options as $option)
                    <input type="text" name="options[]"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ $option->option_text }}" placeholder="Digite uma opção">
                @endforeach
            @else
                <!-- Caso não tenha opções (novo ou sem opções cadastradas), mostrar um campo vazio -->
                <input type="text" name="options[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    placeholder="Opção 1">
            @endif
        </div>
        <button type="button" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
            onclick="addOption()">Adicionar Opção</button>
    </div>


    <div class="flex items-center gap-4">
        <x-primary-button>{{ isset($question) ? 'Atualizar Pergunta' : 'Adicionar Pergunta' }}</x-primary-button>
    </div>
    
</div>

<!-- Script para exibir/esconder opções -->
<script>
    function toggleOptions() {
        var type = document.getElementById("type").value;
        document.getElementById("multiple-options").style.display = (type === "multiple") ? "block" : "none";
    }

    function addOption() {
        var container = document.getElementById("options-container");
        var input = document.createElement("input");
        input.type = "text";
        input.name = "options[]";
        input.classList.add("mt-1", "block", "w-full", "border-gray-300", "rounded-md", "shadow-sm");
        input.placeholder = "Nova opção";
        container.appendChild(input);
    }

    // Garantir que o campo de opções apareça se "Múltipla Escolha" já estiver selecionado
    window.onload = function() {
        toggleOptions();
    };
</script>
