@extends('layouts.user')
<!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Listar-Presupuestos-Usuario')
<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')
    <!--aqui como hay que meter mucho contenido lo ponemos con section haciendo referencia a donde irá el contenido y cerramos con endsection-->

    <div style="padding: 5%;" class=" overflow-x-auto shadow-md sm:rounded-lg">
        <table style="border: 7.5px solid;" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead style="border-radius: 5px; " class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre Cliente
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Apellido
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Nombre Empresa
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Fecha Inicio
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Fecha Final
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Estado
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                </svg></a>

                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Assignar Precio
                        </div>
                    </th>

                    <th>

                    </th>

                </tr>
            </thead>
            <tbody style="background-color: orange">
                @foreach ($list as $pressupost)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $pressupost->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $pressupost->last_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pressupost->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pressupost->start_date }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pressupost->final_date }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $pressupost->status }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('modificar_presupuesto') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">Consultar</a>
                        </td>



                    </tr>
                @endforeach
            </tbody>


        </table>
        <div>
            <br>
        </div>

    </div>

@endsection
