@extends('layouts.user')
<!--utiliza la plantilla con ese nombre, la ruta base se situa en views por eso vamos a layouts y elegimos el que queremos-->

@section('title', 'Aceptar-Presupuestos')
<!--con section le decimos que quremos acceder a la seccion creada con el yeld y le especificamos a que seccion hacemos referencia-->

@section('content')
    <!--aqui como hay que meter mucho contenido lo ponemos con section haciendo referencia a donde irá el contenido y cerramos con endsection-->

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Fecha Creacion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Precio
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Estado
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Aceptado
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span></span>
                    </th>
                    <th>
                        <a href="{{ route('Crear-Presupuestos') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">Crear
                            Presupuesto</a>
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $budget)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $budget->created_at }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $budget->price }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $budget->status }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $budget->accepted }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('Editar-Presupuesto', $budget) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                        </td>

                        <td class="px-6 py-4">
                            <form action="{{ route('Eliminar-Presupuesto', ['budget' => $budget->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
