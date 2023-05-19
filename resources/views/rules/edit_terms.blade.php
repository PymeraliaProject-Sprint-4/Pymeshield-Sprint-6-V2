@extends('layouts.admin')

@section('content')
    <div class="p-5 md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">{{__("edit-terms")}}</h3>
            <p class="mt-1 text-sm text-gray-600">{{__("here-change-terms")}}
            </p>
        </div>
    </div>
    <editor url="/edit_terms" db="terms"/>

@stop
