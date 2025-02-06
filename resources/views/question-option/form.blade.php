<div class="space-y-6">
    
    <div>
        <x-input-label for="question_id" :value="__('Question Id')"/>
        <x-text-input id="question_id" name="question_id" type="text" class="mt-1 block w-full" :value="old('question_id', $questionOption?->question_id)" autocomplete="question_id" placeholder="Question Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('question_id')"/>
    </div>
    <div>
        <x-input-label for="option_text" :value="__('Option Text')"/>
        <x-text-input id="option_text" name="option_text" type="text" class="mt-1 block w-full" :value="old('option_text', $questionOption?->option_text)" autocomplete="option_text" placeholder="Option Text"/>
        <x-input-error class="mt-2" :messages="$errors->get('option_text')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>