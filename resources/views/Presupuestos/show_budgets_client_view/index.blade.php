@extends('layouts.user')
<!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Listar-Presupuestos')
<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')
<show_budgets_client />
@endsection
