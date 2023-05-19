@extends('layouts.user')

@section('content')
    <div class="overflow-x-auto shadow-md sm:rounded-lg m-5">
        <table class="table-auto w-full shadow-lg rounded-lg">
            <thead>
                <tr class="bg-orange-400 text-white md:uppercase">
                    <th scope="col" class="px-4 py-3">
                        {{ __('table.name') }}
                    </th>
                    <th scope="col" class="px-3 md:px-6 py-3">
                        {{ __('questionnaire.name') }}
                    </th>
                    <th scope="col" class="px-3 md:px-6 py-3 hidden md:block">
                        {{ __('table.date') }}
                    </th>
                    <th scope="col" class="px-3 md:px-6 py-3">
                        {{__('actions')}}
                    </th>


                </tr>
            </thead>
            <tbody>
                @foreach ($audits as $audit)
                    <tr class="bg-orange-50 hover:bg-orange-100 text-center">
                        <td scope="row" class="px-3 md:px-6 py-4">
                            {{ $audit->name }}
                        </td>
                        <td class="px-3 md:px-6 py-4">
                            {{ $audit->questionnaire->name }}
                        </td>
                        <td class="px-3 md:px-6 py-4 hidden md:block">
                            {{ date('d-m-Y', strtotime($audit->date))  }}
                        </td>
                        <td class="px-3 md:px-6 py-4">
                            <a href="{{ route('audit.survey', [$audit->id]) }}"
                                class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mt-5 items-center">{{ __('survey.start') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación -->
        <div class="flex justify-center">
            {{ $audits->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
