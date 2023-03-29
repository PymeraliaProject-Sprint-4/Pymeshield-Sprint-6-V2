@extends('layouts.user')

@section('content')

    <div class="m-5 flex items-center pt-4 justify-between space-x-3">
        <div>
            <x-button-link href="{{route('questionnaire.create')}}">
                <i class="fa-solid fa-plus mr-2"></i>
                {{__('questionnaire.create')}}
            </x-button-link>
        </div>
        <div class="flex items-center justify-end">
            <x-button-link href="{{route('questionnaire.hidden')}}">
                {{__('questionnaire.unactive')}}
            </x-button-link>
        </div>
    </div>



    <div class="overflow-x-auto shadow-md sm:rounded-lg m-5">
        <table class="table-auto w-full shadow-lg rounded-lg">
            <thead>
            <tr class="bg-orange-400 text-white">
                <th scope="col" class="px-6 py-3 uppercase">
                    {{__('questionnaire.name')}}
                </th>
                <th scope="col" class="px-6 py-3 uppercase">
                    {{__('questionnaire.autor')}}
                </th>
                <th scope="col" class="px-6 py-3 uppercase">
                    {{__('questionnaire.date')}}
                </th>
                <th scope="col" class="px-6 py-3 uppercase">
                    {{__('actions')}}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($questionnaires as $questionnaire)
                <tr class="bg-orange-50 hover:bg-orange-100 text-center">

                    <th scope="row" class="px-6 py-3 uppercase">
                        {{ $questionnaire->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $questionnaire->autor }}
                    </td>
                    <td class="px-6 py-4">
                        {{ date('d-m-Y', strtotime($questionnaire->date)) }}
                    </td>
                    <td class="flex items-center justify-center px-6 py-4 space-x-3">
                        <x-button-edit href="{{route('questionnaire.edit', $questionnaire)}}" aria-label="edit button">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </x-button-edit>
                        <x-button-unactivate href="{{route('questionnaire.unActivate', $questionnaire)}}" aria-label="hidden button">
                            <i class="fa-regular fa-trash-can"></i>
                        </x-button-unactivate>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="flex justify-center">
            {{ $questionnaires->links('vendor.pagination.tailwind') }}
        </div>
    </div>

@endsection
