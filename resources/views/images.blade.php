<!doctype html>

@extends('layouts.user')

@section('content')

<style>
    #fullpage {
        display: none;
        position: absolute;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-size: contain;
        background-repeat: no-repeat no-repeat;
        background-position: center center;
        background-color: black;
        overflow: hidden;
    }
</style>

<div class="mt-3 md:grid md:grid-cols-5">

    <div class="col-span-2 p-5">
        <h2 class="text-3xl text-center">Información del dispositivo</h2>

        <div class="p-5 bg-orange-300 rounded-md mt-5 flex flex-col gap-y-3">
            <p><strong>Marca:</strong> {{$device->brand}}</p>
            <p><strong>Modelo:</strong> {{$device->model}}</p>
            <p><strong>Tipo:</strong> {{$device->type->name}}</p>
            <p><strong>Número de serie:</strong> {{$device->serial_number}}</p>
            <p><strong>Descripción:</strong> {{$device->description}}</p>
            <p><strong>MAC Ethernet:</strong> {{$device->mac_ethernet}}</p>
            <p><strong>MAC Wifi:</strong> {{$device->mac_wifi}}</p>
        </div>

    </div>

    <div class="p-3 col-span-3">
        <h2 class="text-3xl text-center">Imágenes del dispositivo</h2>

        <div class="flex justify-center">
            <button data-modal-target="addImages" data-modal-toggle="addImages" class="bg-orange-500 hover:bg-orange-400 block text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 mt-3 text-center" type="button">
                Añadir imágenes
            </button>
            <button data-modal-target="showImages" data-modal-toggle="showImages" class="bg-orange-500 hover:bg-orange-400 block text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 mt-3 text-center" type="button">
                Ver imágenes
            </button>
        </div>

        <div class="grid grid-cols-2 gap-5 mt-5">


        </div>

    </div>
</div>

<div id="fullpage" onclick="this.style.display='none';"></div>

@include('modals.addImages')
{{-- @include('modals.showImages') --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
@stop

<html>
