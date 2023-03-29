@extends('layouts.user')

@section('content')
    <survey :survey='{{ json_encode($survey) }}' :questions='{{ json_encode($questions) }}' />
@endsection
