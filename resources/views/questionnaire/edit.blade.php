@extends('layouts.admin')

@section('content')
    <div class="py-3 rounded-lg sm:px-6 lg:px-8">



        <div class="pb-3 sm:rounded-lg">
            <x-button-link
                href="{{ $questionnaire->hidden != null ? route('questionnaire.hidden') : route('questionnaire.index') }}">
                <i class="fa-solid fa-arrow-left">Volver</i>
            </x-button-link>
        </div>

        <div class="max-w-7xl sm:mx-auto m-5 ring-1 ring-gray-200 bg-white rounded-lg p-5">


            <x-success-status class="mb-4" :status="session('message')" />
            <form action="{{ route('questionnaire.update', $questionnaire) }}" method="POST">
                @csrf

                @method('put')

                @if ($questionnaire->hidden != null)
                    <div class="grid mx-auto mb-3 md:grid-cols-5">
                    @else
                        <div class="grid mx-auto mb-3 md:grid-cols-4 md:space-x-3">
                @endif
                <div>
                    <x-input-label for="name" :value="__('questionnaire.name')" />

                    <x-text-input id="name" class="block mt-1" type="text" name="name"
                        value="{{ $questionnaire->name }}" required autofocus />

                    <x-input-error :messages="$errors->get('text')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cost_per_hour" :value="__('questionnaire.autor')" />

                    <x-text-input id="autor" class="block mt-1" type="text" name="autor"
                        value="{{ $questionnaire->autor }}" required autofocus />

                    <x-input-error :messages="$errors->get('text')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="cost_per_hour" :value="__('questionnaire.date')" />

                    <x-text-input id="date" class="block mt-1" type="text" name="date"
                        value="{{ $questionnaire->date }}" required autofocus />

                    <x-input-error :messages="$errors->get('text')" class="mt-2" />
                </div>
                @if ($questionnaire->hidden != null)
                    <div>
                        <x-input-label for="cost_per_hour" :value="__('questionnaire.date.inactivate')" />

                        <x-text-input class="block mt-1" type="text" value="{{ $questionnaire->hidden }}" readonly
                            autofocus />

                        <x-input-error :messages="$errors->get('text')" class="mt-2" />
                    </div>
                @endif
                <div class="flex items-center justify-center">
                    <x-button-check>
                        <i class="fa-solid fa-check text-lg"></i>
                    </x-button-check>
                </div>
        </div>
    </div>
    </form>
    </div>

    <div class="sm:rounded-lg m-5">
        <div class="flex items-center justify-end">
            <x-button-link href="{{ route('question.create') }}">
                {{ __('add.answer') }}
            </x-button-link>
        </div>
    </div>

    <div class="columns-1 sm:columns-2 m-5">
        <div class="overflow-x-auto shadow-md sm:rounded-lg bg-orange-400">
            <form action="{{ route('questionnaire.assignQuestion', $questionnaire) }}" method="POST">
                @csrf

                <div class="flex items-center justify-between px-3 py-2">
                    <div class="text-lg font-medium uppercase">
                        {{ __('assignable.questions') }}
                    </div>
                    <div>
                        <x-button-check>
                            <i class="fa-solid fa-arrow-right text-lg"></i>
                        </x-button-check>
                    </div>
                </div>
                <table class="table-auto w-full shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-orange-400 text-white">
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" name="" type="checkbox"
                                        onclick='checkUncheckAssign(this)'
                                        class="w-4 h-4 text-orange-600 bg-gray-100 rounded border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 uppercase">
                                {{ __('question.name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 uppercase">
                                {{ __('question.description') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unassigned_questions as $question)
                            <tr class="bg-orange-50 hover:bg-orange-100 text-center">
                                <td class="p-4 w-4">
                                    <div class="flex items-center">

                                        <input type="checkbox" id="question-assign-{{ $question->id }}"
                                            value="{{ $question->id }}" name="id[{{ $question->id }}]"
                                            class="w-4 h-4 text-orange-600 bg-gray-100 rounded border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-3 uppercase">
                                    {{ $question->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $question->description }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="overflow-x-auto shadow-md sm:rounded-lg bg-orange-400">
            <form action="{{ route('questionnaire.unassignQuestion', $questionnaire) }}" method="POST">
                @csrf

                <div class="flex items-center justify-between px-3 py-2">
                    <div class="text-lg font-medium uppercase">
                        {{ __('assigned.questions') }}
                    </div>
                    <div>
                        <x-button-check>
                            <i class="fa-solid fa-arrow-left text-lg"></i>
                        </x-button-check>
                    </div>
                </div>
                <table class="table-auto w-full shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-orange-400 text-white">
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" name="" type="checkbox"
                                        onclick='checkUncheckUnAssign(this)'
                                        class="w-4 h-4 text-orange-600 bg-gray-100 rounded border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 uppercase">
                                {{ __('question.name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 uppercase">
                                {{ __('question.description') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assigned_questions as $question)
                            @php($condition1 = $questionnaire->questions->where('id', $question->id)->isNotEmpty())
                            <tr
                                class="bg-orange-50 hover:bg-orange-100 text-center">
                                <td class="p-4 w-4">
                                    <div class="flex items-center">

                                        <input type="checkbox" id="question-unAssign-{{ $question->id }}"
                                            value="{{ $question->id }}" name="id[{{ $question->id }}]"
                                            class="w-4 h-4 text-orange-600 bg-gray-100 rounded border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="px-6 py-3 uppercase">
                                    {{ $question->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $question->description }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script>
        function checkUncheckAssign(main) {
            console.log("main", main.checked);
            var all = document.querySelectorAll('[id^="question-assign-"]');
            for (var a = 0; a < all.length; a++) {
                all[a].checked = main.checked;
            }
        }

        function checkUncheckUnAssign(main) {
            console.log("main", main.checked);
            var all = document.querySelectorAll('[id^="question-unAssign-"]');
            for (var a = 0; a < all.length; a++) {
                all[a].checked = main.checked;
            }
        }
    </script>
@endsection
