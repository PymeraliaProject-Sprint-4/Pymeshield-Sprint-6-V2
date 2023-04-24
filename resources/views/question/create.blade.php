@extends('layouts.admin')

@section('content')
    <div>
        <create-question :risks='{{json_encode($risks)}}' :interventions='{{json_encode($interventions)}}' :type_measures='{{json_encode($type_measures)}}' :probabilities='{{json_encode($probabilities)}}' :impacts='{{json_encode($impacts)}}' />
    </div>
@endsection
