@extends('layouts.user')

@section('title', 'Listado Tareas')

@section('content')
<h1>Aqui vamos a listar todas las tareas</h1>
<ul>
    @foreach ($tasques as $tasca)
        <li class="text-emerald-600">{{$tasca->id}}</li>
        <li class="text-emerald-600">{{$tasca->manages}}</li>
        <li class="text-emerald-600">{{$tasca->user_id}}</li>
    @endforeach
</ul>

{{ $tasques->links()/* este método nos permite paginar*/}} 
@endsection