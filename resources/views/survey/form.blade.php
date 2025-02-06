<div class="space-y-6">

    <div>
        <x-input-label for="title" :value="__('Título da Pesquisa')" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $survey?->title)"
            autocomplete="title" placeholder="Título da sua pesquisa..." />
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
    </div>
    <div>
        <x-input-label for="description" :value="__('Descrição')" />
        <x-textarea id="description" name="description" autocomplete="description" placeholder="Descrição da sua pesquisa.">
            {{ old('description', $survey?->description) }}
        </x-textarea>
        
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Criar</x-primary-button>
    </div>
</div>
