@extends('layouts.user')
<!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Crear-Presupuestos')
<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')

    <a href="{{ route('Aceptar-Presupuestos') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Volver
        a presupuestos</a>

    <form action="{{ route('Enviar-Presupuesto') }}" method="POST">

        @csrf

        <label>
            <br>
            Fecha creacion:
            <input type="date" name="created_at">
        </label>
        <br>
        <br>
        <label>
            <br>
            Hidden:
            <input type="date" name="hidden">
        </label>
        <br>
        <br>
        <label>
            Precio:
            <input type="text" name="price">
        </label>
        <br>
        <br>
        <label>Estado:
            <select name="status">
                <option value="Pending">Pending</option>
                <option value="Waiting">Waiting</option>
                <option value="Done">Done</option>
            </select>
        </label>
        <br>
        <br>
        <label>
            Aceptado:
            <select name="accepted">
                <option value="Si">Si</option>
                <option value="No">No</option>
            </select>
        </label>
        <br>
        <br>
        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Enviar
            presupuesto</button>


    </form>

@endsection
