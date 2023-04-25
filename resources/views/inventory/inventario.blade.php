<!doctype html>

@extends('layouts.user')

@section('content')
    <div id="app">
        <h1 class="text-center p-2 mt-2 text-3xl">{{__('inventory.title')}}</h1>

        <div><inventory /></div>

    </div>
@endsection
