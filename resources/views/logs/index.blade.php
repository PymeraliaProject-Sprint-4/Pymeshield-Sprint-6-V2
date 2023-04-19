@extends('layouts.admin')

@section('content')
    <div class="max-w-screen-2xl m-4">
        <h1 class="text-2xl font-bold mb-4">Logs</h1>

        <form action="/logs" method="get" id="logsSearchForm" class="flex items-center">
            @csrf
            <div class="mr-4">
                <label for="searchSelect" class="block mb-2">Filtrar por Usuario</label>
                <select name="search" id="searchSelect"
                        class="w-64 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccionar usuario</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->email }}">{{ $user->id }} - {{ $user->name }}
                            - {{ $user->email }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 m-2">
                    Buscar
                </button>
            </div>
        </form>

        <pre class="mt-4">{{ trim($logs) }}</pre>
    </div>
@endsection


