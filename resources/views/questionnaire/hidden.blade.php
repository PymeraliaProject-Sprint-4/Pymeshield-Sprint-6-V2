@extends('layouts.app')

@section('content')

    <div class="m-5 flex items-center pt-4 justify-between">
        <div>
            <x-button-link href="{{route('questionnaire.index')}}">
                {{__('questionnaire.active')}}
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
                    {{__('questionnaire.date.inactivate')}}
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
                <td class="px-6 py-4">
                    {{ date('d-m-Y', strtotime($questionnaire->hidden)) }}
                </td>
                <td class="flex items-center justify-center px-6 py-4 space-x-3">
                    <x-button-edit href="{{route('questionnaire.edit', $questionnaire)}}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </x-button-edit>
                    <x-button-activate href="{{route('questionnaire.activate', $questionnaire)}}">
                        <i class="fa-solid fa-arrow-up"></i>
                    </x-button-activate>
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
