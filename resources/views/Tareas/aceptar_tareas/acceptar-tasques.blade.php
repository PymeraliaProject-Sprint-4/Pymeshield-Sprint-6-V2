@extends('layouts.user') <!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Aceptación Tareas')<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')<!--aqui como hay que meter mucho contenido lo ponemos con section haciendo referencia a donde irá el contenido y cerramos con endsection-->    
    <tabla_aceptar_tareas />
@endsection