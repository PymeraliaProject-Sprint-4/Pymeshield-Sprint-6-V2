@extends('layouts.user')
@section('content')
    {{-- En este div estará alojado el componente de Vue de la tabla de tareas --}}
    {{-- <div id="app" class="container mx-auto mt-10 mb-10 relative overflow-x-auto"> --}}
    <div class="container mx-auto mt-10 mb-10 overflow-x-auto">
        <modificar_presupuesto />
    </div>
@endsection
