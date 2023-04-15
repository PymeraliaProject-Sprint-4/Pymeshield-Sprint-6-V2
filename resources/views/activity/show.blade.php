@extends('layouts.user')

@section('content')
    <deliveries :course="{{ $course->id }}" :activity="{{ $activity->id }}" />

@stop
