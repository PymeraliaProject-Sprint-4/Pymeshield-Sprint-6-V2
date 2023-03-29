@extends('layouts.user')
<!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Editar-Presupuestos')
<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')

    <a href="{{ route('Aceptar-Presupuestos') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Volver
        a presupuestos</a>

    <form action="{{ route('Update-Presupuesto', $id) }}" method="POST">

        @csrf
        @method('put')

        <label>
            <br>
            Fecha creacion:
            <!--Utilizo la funcion strtotime para convertir a un formato de fecha el valor de la columna created_at que es timestamp -->
            <input type="date" name="created_at" value="{{ date('Y-m-d', strtotime($id->created_at)) }}">
        </label>

        <br>
        <br>
        <label>
            <br>
            Hidden:
            <input type="date" name="hidden" value="{{ $id->hidden }}">
        </label>
        <br>
        <br>
        <label>
            Precio:
            <input type="text" name="price" value="{{ $id->price }}">
        </label>
        <br>
        <br>
        <label>Estado:
            <select name="status">
                <option value="Pending" {{ $id->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Waiting" {{ $id->status == 'Waiting' ? 'selected' : '' }}>Waiting</option>
                <option value="Done" {{ $id->status == 'Done' ? 'selected' : '' }}>Done</option>
            </select>
        </label>

        <br>
        <br>
        <label>Aceptado:
            <select name="accepted">
                <option value="Si" {{ $id->accepted == 'Si' ? 'selected' : '' }}>Si</option>
                <option value="No" {{ $id->accepted == 'No' ? 'selected' : '' }}>No</option>
            </select>
        </label>

        <br>
        <br>
        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar
            presupuesto</button>


    </form>

@endsection
