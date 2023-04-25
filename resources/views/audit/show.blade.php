@extends('layouts.user')

@section('content')
    <audit :survey='{{ json_encode($survey) }}' :questions='{{ json_encode($questions) }}' />
@endsection
