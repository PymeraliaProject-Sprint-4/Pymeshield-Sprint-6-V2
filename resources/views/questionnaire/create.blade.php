@extends('layouts.user')

@section('content')


    <div>
        <questionnaire-component :questionnaires='{{json_encode($questionnaires)}}' />
    </div>

@endsection
