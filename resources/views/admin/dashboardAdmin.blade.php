@extends('layouts.admin')

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 m-4">
        <div class="">
            <div class="border p-4">
                <h2>{{ __('dashboard.admin.title') }}</h2>
            </div>
            <div class="border p-4 mt-6">
                <h2>{{ __('dashboard.admin.p1') }}</h2>
            </div>
        </div>
        <div>
            <chart-admin />
        </div>
    </div>

@stop
