<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-row items-baseline justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __("Questions") }}
            </h2>
        </div>

    </x-slot>

    @push('styles')
    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: #F0F0F0;
        }

        .sortable-handle {
            cursor: move;
            padding: 0.25rem;
            margin-right: 0.5rem;
            color: #6B7280;
        }

        .sortable-handle:hover {
            color: #374151;
        }
    </style>
    @endpush

    <div class="w-full py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg ">
                <div class="grid grid-cols-1 gap-4 p-6 text-gray-900 ">
                    <div class="relative flex flex-col w-full px-8 py-4 bg-white rounded-lg shadow-sm ">

                        <h3 class="text-lg font-semibold text-center ">{{$quiz->title}}</h3>

                        <form method="POST" action="{{route('questions.store', $quiz->id)}}"
                            class="grid items-center w-full grid-cols-1 mt-8 lg:grid-cols-5 align-center lg:gap-x-4 lg:gap-y-4 gap-y-8">
                            @method('POST')
                            @csrf
                            <div class="lg:col-span-2 ">
                                <x-text-input id="question_text" class="block w-full" type="text" name="question_text"
                                    :value="old('question_text')" required placeholder="Question"
                                    data-test="add-question-question-text-field" />

                                <x-input-error :messages="$errors->get('question_text')" class="w-full mt-2" />
                            </div>
                            <div class="flex flex-col gap-y-4 lg:items-center lg:flex-row lg:col-span-2 gap-x-8">
                                <x-text-input id="points" class="block w-20" type="number" name="points"
                                    :value="old('points')" placeholder="Points"
                                    data-test="add-question-points-text-field" required />
                                <x-input-error :messages="$errors->get('points')" class="mt-2" />


                                <div class="flex lg:flex-col gap-x-4 gap-y-2">
                                    <div class="flex items-center gap-2 ">
                                        <x-text-input id="question_type"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2"
                                            type="radio" name="question_type" value="true_false"
                                            data-test="add-question-true-false-radio" />
                                        <x-input-label for="question_type" :value="__('True or false')" />

                                    </div>


                                    <div class="flex items-center gap-2">
                                        <x-text-input id="question_type"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2"
                                            value="multiple_choice" type="radio" name="question_type"
                                            data-test="add-question-multiple-choice-radio" />
                                        <x-input-label for="question_type" :value="__('Multiple choice')" />

                                    </div>
                                </div>

                            </div>


                            <x-primary-button data-test="add-question-form-save-button"
                                class="flex items-center justify-center w-20 ">
                                {{ __('Add') }}
                            </x-primary-button>
                        </form>

                        <div class="flex flex-col" id="questionsList">

                            @foreach ($questions as $question)


                            <div class="grid items-center w-full px-4 mt-12 sortable-item lg:grid-cols-5 align-center lg:gap-x-4 lg:gap-y-4 gap-y-8 auto-rows-min"
                                data-id="{{ $question->id }}" data-order="{{ $question->order_number }}">
                                <div class="flex flex-row items-center col-span-2 gap-x-2">
                                    <p class="text-lg font-bold">{{$loop->iteration}}</p>

                                    <form method="post"
                                        action="{{ route('questions.update', ['quiz' => $quiz->id, 'question' => $question->id]) }}"
                                        class="w-full">
                                        @method('PATCH')
                                        @csrf
                                        <x-text-input id="question_text" class="block w-full border-none shadow-none"
                                            type="text" name="question_text" value="{{$question->question_text}}"
                                            onChange="this.form.submit()" required placeholder="Question"
                                            data-test="edit-question-question-text-field" />

                                    </form>
                                </div>
                                <div class="flex flex-row lg:col-span-2 gap-x-2">
                                    <form method="post"
                                        action="{{ route('questions.update', ['quiz' => $quiz->id, 'question' => $question->id]) }}">
                                        @method('PATCH')
                                        @csrf
                                        <x-text-input id="points" class="block w-20 border-none shadow-none"
                                            type="number" name="points" onChange="this.form.submit()"
                                            value="{{$question->points}}" placeholder="Points"
                                            data-test="edit-question-points-text-field" required />
                                    </form>
                                    <form method="post"
                                        action="{{ route('questions.update', ['quiz' => $quiz->id, 'question' => $question->id]) }}"
                                        class="flex items-center">
                                        @method('PATCH')
                                        @csrf

                                        <div class="flex lg:flex-row gap-x-4 gap-y-2">
                                            <div class="flex items-center gap-2 ">
                                                <x-text-input id="question_type"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2"
                                                    type="radio" name="question_type" value="true_false"
                                                    data-test="edit-question-true-false-radio"
                                                    :checked="$question->question_type == 'true_false'"
                                                    onChange="this.form.submit()" />
                                                <x-input-label for="question_type" :value="__('True or false')" />

                                            </div>
                                            <div class="flex items-center gap-2">
                                                <x-text-input id="question_type"
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2"
                                                    value='multiple_choice' type="radio" name="question_type"
                                                    data-test="edit-question-multiple-choice-radio"
                                                    :checked="$question->question_type == 'multiple_choice'"
                                                    onChange="this.form.submit()" />
                                                <x-input-label for="question_type" :value="__('Multiple choice')" />

                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div
                                    class="flex justify-center w-full lg:justify-end gap-x-4 lg:col-span-1 lg:self-center">

                                    <form class="flex items-center"
                                        action="{{ route('questions.destroy', ['quiz' => $quiz->id, 'question' => $question->id]) }}"
                                        method="post">
                                        @method('delete')
                                        @csrf

                                        <button data-test="edit-question-delete-button"
                                            class="text-xs font-bold text-red-500 uppercase"
                                            onclick="return confirm('Are you sure you want to delete this question?')"
                                            type="submit">Delete</button>
                                    </form>

                                    <span class="text-gray-500 cursor-pointer sortable-handle">&#8942;&#8942;</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            $(function () {
                if (typeof Sortable === "undefined") {
                    console.error("Sortable.js is NOT loaded!");
                    return;
                }
                console.log("Sortable.js is loaded successfully.");
        
                let questionsList = $("#questionsList");
        
                if (questionsList.length === 0) {
                    console.error("Error: #questionsList not found!");
                    return;
                }
        
                new Sortable(questionsList[0], {  // Correctly reference the DOM element
                    animation: 150,
                    onEnd: function () {
                        let reorderedQuestions = [];
        
                        $("#questionsList .sortable-item").each(function (index) {
                            reorderedQuestions.push({
                                id: $(this).data("id"),  // Ensure each item has `data-id`
                                order_number: index + 1  // Assign new order based on index
                            });
                        });
        
                        // Send updated order via AJAX
                        $.ajax({
                            url: "/quizzes/7/questions/reorder",
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // ✅ Fetch CSRF token
                            },
                            contentType: "application/json",
                            data: JSON.stringify({ questions: reorderedQuestions }),
                            dataType: "json",
                            success: function (response) {
                                console.log("Reorder success:", response);
                            },
                            error: function (xhr, status, error) {
                                console.error("Error:", xhr.responseText);
                            }
                        });
                    }
                });
            });
        </script>

        @endpush


</x-app-layout>