@extends('layouts.user')

@section('content')
{{-- <div>
    <h1 class="pt-6 text-center font-semibold">{{__('dashboard')}} {{auth()->user()->name}} {{auth()->user()->last_name}}</h1>
</div> --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 m-4">
    <div>
        <div class="p-4 overflow-auto bg-slate-100 rounded-lg">
            <table-weeks />
        </div>
        <div class="p-4 mt-6 overflow-auto bg-slate-100 rounded-lg">
            <activity-weeks />
        </div>
    </div>
    <div class=" xl:px-28 pb-28 lg:px-56 md:px-28 sm:px-0 pt-4 bg-slate-100 rounded-lg">
        <chart-user />
    </div>
</div>
@stop