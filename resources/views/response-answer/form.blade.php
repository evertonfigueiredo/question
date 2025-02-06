<div class="space-y-6">
    
    <div>
        <x-input-label for="unique_id" :value="__('Unique Id')"/>
        <x-text-input id="unique_id" name="unique_id" type="text" class="mt-1 block w-full" :value="old('unique_id', $responseAnswer?->unique_id)" autocomplete="unique_id" placeholder="Unique Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('unique_id')"/>
    </div>
    <div>
        <x-input-label for="survey_id" :value="__('Survey Id')"/>
        <x-text-input id="survey_id" name="survey_id" type="text" class="mt-1 block w-full" :value="old('survey_id', $responseAnswer?->survey_id)" autocomplete="survey_id" placeholder="Survey Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('survey_id')"/>
    </div>
    <div>
        <x-input-label for="question_id" :value="__('Question Id')"/>
        <x-text-input id="question_id" name="question_id" type="text" class="mt-1 block w-full" :value="old('question_id', $responseAnswer?->question_id)" autocomplete="question_id" placeholder="Question Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('question_id')"/>
    </div>
    <div>
        <x-input-label for="answer" :value="__('Answer')"/>
        <x-text-input id="answer" name="answer" type="text" class="mt-1 block w-full" :value="old('answer', $responseAnswer?->answer)" autocomplete="answer" placeholder="Answer"/>
        <x-input-error class="mt-2" :messages="$errors->get('answer')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>