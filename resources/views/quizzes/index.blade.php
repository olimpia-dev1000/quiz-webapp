<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-row items-baseline justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Quizzes') }}
            </h2>

            <a href="/quizzes/create" data-test="add-quiz-link"
                class="p-4 text-white bg-indigo-700 rounded-md hover:cursor-pointer hover:bg-indigo-900">
                {{ __('Add new quiz') }}
            </a>
        </div>

    </x-slot>

    <div class="w-full py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg min">
                <div class="grid grid-cols-1 gap-4 p-6 text-gray-900 md:grid-cols-2 lg:grid-cols-3">

                    @if (count($quizzes) > 0 )

                    @foreach ($quizzes as $quiz)
                    <div class="relative flex flex-col px-8 py-4 bg-white rounded-lg shadow-sm min-h-40">
                        <span class="mt-4 text-sm text-gray-400 ">Created {{ $quiz->created_at->diffForHumans()
                            }}</span>
                        <h3 class="font-bold ">{{ $quiz->title }}</h3>
                        <p class="mt-2 text-gray-700">{{ $quiz->description }}</p>

                        <a class="absolute right-0 flex items-center justify-center w-10 h-10 p-2 mx-auto mt-4 text-sm font-bold text-center text-white bg-gray-600 rounded-md -top-4 hover:bg-gray-800"
                            href="{{route('quizzes.edit', $quiz->id)}}"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </a>
                        <a class="absolute right-0 flex items-center justify-center w-10 h-10 p-2 mx-auto mt-4 text-sm font-bold text-center text-white bg-green-600 rounded-md top-8 hover:bg-green-800"
                            data-test="add-quiz-form-add-questions-button" href="{{route('questions', $quiz->id)}}"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </a>

                        <form action="{{route('quizzes.destroy', $quiz->id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button
                                class="absolute right-0 flex items-center justify-center w-10 h-10 p-2 mx-auto mt-4 text-sm font-bold text-center text-white bg-red-600 rounded-md top-20 hover:bg-red-800"
                                data-test="add-quiz-form-delete-quiz-button"
                                href="{{route('quizzes.destroy', $quiz->id)}}" type="submit"
                                onclick="return confirm('Are you sure you want to delete this quiz?')"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                                </svg>
                            </button>
                        </form>

                    </div>
                    @endforeach
                    @else
                    <p>Use button above to add your first quizz</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>