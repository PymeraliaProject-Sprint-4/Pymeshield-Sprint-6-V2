@extends('layouts.user')

@section('content')
    <!-- TAULA DE EMBLEMES -->
                    <div id="margin_table" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full shadow-lg rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-white-100">
                                <tr class="bg-orange-400 text-white">
                                    <th class="text-xs text-white uppercase p-4">
                                        Nombre
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        Descripcion
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        Emblema
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        Nombre Curso
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        <div class="inline-flex">
                                            <button onclick="window.location.href='{{ route('emblems.create') }}'"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 flex items-center"
                                                type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                  </svg>
                                                  Crear Emblema
                                            </button>
                                            <button
                                                onclick="window.location.href='{{ route('emblems.restaurar') }}'"
                                                class="bg-yellow-800 hover:bg-yellow-700 text-white font-bold py-2 px-4 flex items-center"
                                                type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                  </svg>
                                                Restaurar
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emblems as $emblem)
                                    <tr class="bg-orange-50 hover:bg-orange-100 text-center">
                                        <td class="break-all px-6 py-4 font-medium text-gray-900">
                                            {{ $emblem->name }}
                                        </td>
                                        <td>
                                            {{ $emblem->description }}
                                        </td>
                                        <td>
                                            <img src = "{{asset($emblem->image)}}" alt = "{{$emblem->title}}" class="img-flud" width = "60">
                                            <!--{{ $emblem->image }}-->
                                        </td>
                                        <td>
                                            {{ $emblem->course->name }}
                                        </td>
                                        <td>
                                            <div class="inline-flex">
                                                <button onclick="window.location.href='{{ route('emblems.edit', $emblem->id, $emblem->course->id) }}'"
                                                    class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                      </svg>
                                                </button>
                                               <button onclick="window.location.href='{{ route('emblems.eliminar', $emblem->id) }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 ml-2 rounded " type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                  </svg>

                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $emblems->links('pagination::tailwind', ['max_links' => 5]) }}
                    </div>
@stop
