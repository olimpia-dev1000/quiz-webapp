<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-row items-baseline justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __("Answers") }}
            </h2>
        </div>

    </x-slot>

    {{-- @push('styles')
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
    @endpush --}}

    <div class="w-full py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg ">
                <div class="grid grid-cols-1 gap-4 p-6 text-gray-900 ">
                    <div class="relative flex flex-col w-full px-8 py-4 bg-white rounded-lg shadow-sm ">

                        <h3 class="text-lg font-semibold text-center ">{{$question->question_text}}</h3>



                        <div class="flex flex-col" id="questionsList">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- @push('scripts')
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

        @endpush --}}


</x-app-layout>