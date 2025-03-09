<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-row items-baseline justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __("Answers") }}
            </h2>
        </div>

    </x-slot>

    <div class="w-full py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg ">
                <div class="grid grid-cols-1 gap-4 p-6 text-gray-900 ">
                    <div class="relative flex flex-col items-center w-full px-8 py-4 bg-white rounded-lg shadow-sm ">

                        <h3 class="text-lg font-semibold text-center ">{{$question->question_text}}</h3>

                        @if ($answersReachedLimit || !$canBeEdited)
                        <p class="mt-4 font-semibold text-green-700">All answers added!</p>
                        @else
                        <form method="post"
                            action="{{ route('answers.store', ['quiz' => $quiz->id, 'question' => $question->id]) }}"
                            class="flex flex-row items-center w-3/4 gap-4 mx-auto mt-8">
                            @csrf
                            <x-text-input id="answer_text" class="block w-3/5 border-none shadow-none" type="text"
                                name="answer_text" :value="old('answer_text')" required placeholder="Answer"
                                data-test="add-answer-answer-text-field" />

                            <div class="flex flex-row items-center justify-center gap-4">
                                <x-text-input id="is_correct" class="block w-4 h-4 rounded-sm" type="checkbox"
                                    name="is_correct" value="0" data-test="add-answer-is-correct-checkbox"
                                    :disabled="$hasCorrectAnswer" />

                                <x-input-label for="is_correct" :value="__('Correct answer')" class="w-full" />

                            </div>
                            <x-primary-button data-test="add-answer-answer-submit-button">Submit
                            </x-primary-button>
                        </form>

                        @endif

                        @foreach ($answers as $answer)

                        <div
                            class="grid items-center w-full px-4 mt-12 lg:grid-cols-3 align-center lg:gap-x-4 lg:gap-y-4 gap-y-8 auto-rows-min">
                            <div class="flex flex-row items-center w-full gap-x-2">

                                <p>{{$loop->iteration}}</p>

                                <form method="post"
                                    action="{{ route('answers.update', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]) }}"
                                    class="w-full">
                                    @method('PATCH')
                                    @csrf
                                    <x-text-input id="answer_text" class="block w-full border-none shadow-none"
                                        type="text" name="answer_text" value="{{$answer->answer_text}}"
                                        onChange="this.form.submit()" required placeholder="Answer"
                                        data-test="edit-answer-answer-text-field" :disabled="!$canBeEdited" />

                                </form>
                            </div>

                            <form method="post"
                                action="{{ route('answers.update', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]) }}"
                                class="flex flex-row items-center justify-center gap-4">
                                @method('PATCH')
                                @csrf
                                <x-text-input id="is_correct" class="block w-4 h-4 rounded-sm" type="checkbox"
                                    name="is_correct" value="{{$answer->is_correct}}" onChange="this.form.submit()"
                                    data-test="edit-answer-is-correct-checkbox"
                                    :disabled="$hasCorrectAnswer && !$answer->is_correct" />

                                <x-input-label for="is_correct" :value="__('Correct answer')" class="w-full" />
                            </form>

                            <form class="flex items-center"
                                action="{{ route('answers.destroy', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]) }}"
                                method="post">
                                @method('delete')
                                @csrf
                                <button data-test="add-answer-answer-delete-button"
                                    class="text-xs font-bold text-red-500 uppercase"
                                    onclick="return confirm('Are you sure you want to delete this answer?')"
                                    type="submit" {{!$canBeEdited ? 'disabled' : '' }}>Delete</button>
                            </form>

                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

</x-app-layout>