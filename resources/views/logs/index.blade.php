@extends('layouts.admin')

@section('content')
    <div class="max-w-screen-2xl m-6">
        <h1 class="text-2xl font-semibold mb-4">Logs</h1>

        <form action="/logs" method="get" id="logsSearchForm" class="flex flex-wrap items-center">
            @csrf
            <div class="mb-4 w-full">
                <select name="search" id="searchSelect" class="w-full px-4 py-2 bg-white border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md ">
                    <option value="">{{__('select_user')}}</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->email }}">{{ $user->id }} - {{ $user->name }} - {{ $user->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4 w-full">
                <div class="w-full">
                    <label for="start_date" class="mr-2">{{__('start_date')}}:</label>
                    <input type="date" name="start_date" id="start_date" class="w-full px-4 py-2 bg-white border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md">
                </div>

                <div class="w-full">
                    <label for="end_date" class="mr-2">{{__('end_date')}}:</label>
                    <input type="date" name="end_date" id="end_date" class="w-full px-4 py-2 bg-white border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md">
                </div>
            </div>

            <div class="flex flex-col md:flex-row mb-2">
                <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 md:mr-4 mt-4 md:mt-0">
                    {{__('search')}}
                </button>
            </div>
        </form>

            <div class="border-2 border-gray-400 rounded-lg shadow-xl bg-white py-2 px-2" style="overflow-x: auto;">
                <pre class="whitespace-pre-wrap">{{ $logs }}</pre>
            </div>
        </div>

@endsection


