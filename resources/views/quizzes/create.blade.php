<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-row items-baseline justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Add Quiz') }}
            </h2>
            {{--
            <a href="/quizzes/create" data-test="add-quiz-link"
                class="p-4 text-white bg-indigo-700 rounded-md hover:cursor-pointer hover:bg-indigo-900">
                {{ __('Add new quiz') }}
            </a> --}}
        </div>

    </x-slot>

    <div class="w-full py-12 mx-2 md:w-3/4 lg:w-1/2">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                    <form action="{{ route('quizzes.store') }}" method="POST" data-test="add-quiz-form">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block w-full mt-2" type="text" name="title"
                                :value="old('title')" required autofocus placeholder="Basics of Laravel"
                                data-test="add-quiz-form-title-field" />

                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" class="mt-4" />
                            <x-textarea-input id="description" class="block w-full mt-2" type="text" name="description"
                                required autofocus placeholder="Testing your Laravel knowledge..."
                                data-test="add-quiz-form-description-field">{{ old('description') }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Time limit field and is public toggle -->

                        <div class="">

                            <x-input-label for="time_limit" :value="__('Time limit (minutes)')" class="mt-4" />
                            <x-text-input id="time_limit" class="block mt-2 w-14" type="number" name="time_limit"
                                :value="old('time_limit')" required autofocus placeholder="15"
                                data-test="add-quiz-form-time-limit-field" />
                            <x-input-error :messages="$errors->get('time_limit')" class="mt-2" />



                        </div>

                        <!-- Buttons -->

                        <div class="flex items-center justify-end mt-4">
                            <a href=" {{route('quizzes') }} ">
                                <x-secondary-button class="ms-3" data-test="add-quiz-form-cancel-button">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                            </a>

                            <x-primary-button class="ms-3" data-test="add-quiz-form-save-button">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>


                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>