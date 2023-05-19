@extends('layouts.user') <!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Crear Presupuesto')<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')<!--aqui como hay que meter mucho contenido lo ponemos con section haciendo referencia a donde irá el contenido y cerramos con endsection-->
<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
<div class="mx-auto max-w-lg text-center">
  <h1 class="text-2xl font-bold sm:text-3xl">Crear nuevo presupuesto</h1>
</div>

<form action="{{route('enviar-pressupost')}}" method="POST" class="mx-auto mt-8 mb-0 max-w-md space-y-4">

    @csrf <!--directiva que genera un token para poder enviar datos de forma segura -->

  <div>
    <label for="precio" class="sr-only">Precio</label>

    <div class="relative">
      <input
        type="number"
        name="price"
        class="w-full rounded-lg border-gray-200 p-4 pr-12 text-sm shadow-sm"
        placeholder="Precio Presupuesto"
      />
    </div>

    <br>
    <button
      type="submit"
      class="ml-3 inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white"
    >
      Crear
    </button>
  </div>
</form>
</div>
@endsection