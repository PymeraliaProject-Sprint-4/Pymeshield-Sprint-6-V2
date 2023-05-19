@extends('layouts.user')

@section('content')
    <div><audit :survey='{{ json_encode($survey) }}' :questions='{{ json_encode($questions) }}' /></div>
@endsection
