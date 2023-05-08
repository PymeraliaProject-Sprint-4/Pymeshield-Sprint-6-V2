@extends('layouts.admin')

@section('content')
    <!-- TAULA DE EMBLEMES -->

    <div class="max-w-screen-lg mx-auto px-4">
        <h1 class="ml-7 mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ __('Admin') }}</span>
        </h1>
        <p class="ml-7 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ __('phrase.1.emblem') }}
        </div>
        </p><br>
                    <div id="margin_table" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full shadow-lg rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-white-100">
                                <tr class="bg-orange-400 text-white">
                                    <th class="text-xs text-white uppercase p-4">
                                        {{ __('table.name') }}
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        {{__('emblem-description')}}
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        {{__('emblem')}}
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        {{__('emblem-name-course')}}
                                    </th>
                                    <th class="text-xs text-white uppercase p-4">
                                        {{__('actions')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emblems as $emblem)
                                    <tr class="bg-orange-50 hover:bg-orange-100 text-center">
                                        <td class="px-6 py-4">
                                            {{ $emblem->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $emblem->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <img src = "{{asset($emblem->image)}}" alt = "{{$emblem->title}}" class="img-flud" width = "60">
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $emblem->course->name }}
                                        </td>
                                        <td>
                                            <div class="inline-flex">
                                                <button onclick="window.location.href='{{ route('restaurar.hide', $emblem->id) }}'"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 flex items-center"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
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
                </div>
@stop
