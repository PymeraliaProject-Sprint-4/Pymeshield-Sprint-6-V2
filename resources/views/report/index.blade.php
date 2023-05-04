@extends('layouts.user')

@section('content')
    <div class="overflow-x-auto shadow-md sm:rounded-lg m-5">
        <table class="table-auto w-full shadow-lg rounded-lg">
            <thead>
                <tr class="bg-orange-400 text-white">


                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('table.name') }}
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('table.status') }}
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('table.date') }}
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        {{ __('actions') }}
                    </th>


                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr class="bg-orange-50 hover:bg-orange-100 text-center">


                        <td class="px-6 py-4">
                            {{ $report->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ __('report.' . $report->status) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ date('d-m-Y', strtotime($report->date)) }}
                        </td>
                        <td class="flex items-center justify-center px-6 py-4 space-x-1">
                                <a class="bg-orange-500 hover:bg-gray-700 text-white font-bold py-2 px-3 ml-2 rounded"
                                    href="{{ route('report.show', [$report->id]) }}"><i class="fa-solid fa-eye"></i></a>
                                <div>
                                    <report-modificar :id='{{ json_encode($report->id) }}'
                                        :name='{{ json_encode($report->name) }}'
                                        :status='{{ json_encode($report->status) }}' />
                                </div>
                                <div>
                                    <report-eliminar :id='{{ json_encode($report->id) }}' />
                                </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación -->
        <div class="flex justify-center">
            {{ $reports->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
