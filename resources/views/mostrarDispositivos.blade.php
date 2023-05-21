<!doctype html>

@extends('layouts.user')

@section('content')
<h1 class="text-center p-8 mt-2 text-3xl">Listado dispositivos</h1>
<div style="display:flex; justify-content:center">
<table class="container shadow-xl table-auto w-full rounded-lg bg-white mt-5 w-99 text-center">
    <thead class="bg-orange-500 text-white">
      <!-- camps de la taula a omplir, capçalera -->
      <tr>
        <th></th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>MAC</th>
        <th>Wifi</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Núm Serie</th>
        <th><button data-modal-target="crear" data-modal-toggle="crear" class="fa-solid fa-plus m-2 text-blue-600 text-2xl">
        </button><button data-modal-target="eliminar" data-modal-toggle="eliminar" class="fa-solid fa-trash-can m-2 text-red-700 text-2xl">
        </button>
      </tr>
    </thead>
    <tbody>
      @foreach ($dispositivos as $inventario)
      <tr class="bg-orange-100 hover:bg-orange-300">
        <!-- camps omplerts amb dades de la base de dades -->
        <td>
            <input id="checkbox" type="checkbox">
        </td>
        <td>{{$inventario->brand}}</td>
        <td>{{$inventario->model}}</td>
        <td>{{$inventario->mac_ethernet}}</td>
        <td>{{$inventario->mac_wifi}}</td>
        <td>{{$inventario->type_device_id}}</td>
        <td>{{$inventario->description}}</td>
        <td>{{$inventario->state}}</td>
        <td>{{$inventario->serial_number}}</td>
        <td>
          <div class="flex">
          <button data-modal-target="modificar{{ $inventario->id }}" data-modal-toggle="modificar{{ $inventario->id }}" class="fa-sharp fa-solid fa-pencil m-2 text-yellow-600 text-2xl">
        </button>
        <button data-modal-target="eliminar{{ $inventario->id }}" data-modal-toggle="eliminar{{ $inventario->id }}" class="fa-sharp fa-solid fa-trash m-2 text-red-600 text-2xl">
        </button>
        <a data-modal-target="imatge{{ $inventario->id }}" data-modal-toggle="imatge{{ $inventario->id }}" class="fa-sharp fa-solid fa-image m-2 text-green-600 text-2xl" href="dispositivo/{{ $inventario->id }}">
        </a>
      </div>
        </td>
      </tr>
      <!-- include dels modals que usarem en aquest cas com usarem editar i eliminar a toa la taula pues es posa dintre del bucle -->
      @include ("modals/eliminarDispositivo")
      @include ("modals/modificarDispositivo")
      @endforeach
      <!-- aquest include fora ja que nomes és fa una sola vegada -->
@include ("modals/crearDispositivo")
    </tbody>
  </table>
</div>
<!-- Paginació -->
<div class="flex justify-center mb-3">
  {{$dispositivos->links()}}
  </div>
@stop

<html>
