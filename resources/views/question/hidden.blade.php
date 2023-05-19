@extends('layouts.admin')

@section('content')
    <div class="m-5 flex items-center pt-4 justify-between space-x-3">
        <div>
            <x-button-link href="{{ route('question.create') }}">
                <i class="fa-solid fa-plus mr-2"></i>
                {{ __('question.create') }}
            </x-button-link>
        </div>
        <div class="flex items-center justify-end">
            <x-button-link href="{{ route('question.index') }}">
                {{ __('question.active') }}
            </x-button-link>
        </div>
    </div>
    <div class="overflow-x-auto shadow-md sm:rounded-lg m-5">
        <table class="table-auto w-full shadow-lg rounded-lg">
            <thead>
                <tr class="bg-orange-400 text-white">
                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('question.name') }}
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('question.description') }}
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr class="bg-orange-50 hover:bg-orange-100 text-center">
                        <td scope="row" class="px-6 py-4">
                            {{ $question->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $question->description }}
                        </td>
                        <td class="flex items-center justify-center px-6 py-4 space-x-3">
                            <x-button-edit class="openModal" href="{{ route('question.edit', $question) }}">
                                <i class="fa-regular fa-pen-to-square "></i>
                            </x-button-edit>
                            <x-button-activate href="{{ route('question.activate', $question) }}">
                                <i class="fa-solid fa-arrow-up"></i>
                            </x-button-activate>
                        </td>
                    </tr>
                @endforeach

                <!-- This example requires Tailwind CSS v2.0+ -->

            </tbody>
        </table>

        <div class="flex justify-center">
            {{ $questions->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
