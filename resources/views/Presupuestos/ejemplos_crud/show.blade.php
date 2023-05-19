@extends('layouts.user') <!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Mostrar Presupuestos')<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')<!--aqui como hay que meter mucho contenido lo ponemos con section haciendo referencia a donde irá el contenido y cerramos con endsection-->
    
    <a href="{{route('crear-pressupost')}}" class="text-cyan-500">Crear Nuevo Presupuesto</a>

    <ul>   
        @foreach ($pressupostos as $pressupost)
                <li>{{$pressupost->id}}</li>
                <li>{{$pressupost->price}}</li>
                <li>{{$pressupost->status}}</li>
                <br>
        @endforeach
    </ul>
@endsection