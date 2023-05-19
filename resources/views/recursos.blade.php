@extends('layouts.user')

@section('content')
  <h1 style="text-align: center"><strong class="text-4xl">Recursos</strong></h1>

  <div class="flex-1 flex-col ml-2">
    

        @foreach($resourcesByCategory as $categoryName => $resources)
            <div class="bg-orange-200 rounded-lg p-5 m-2">
                <div class="flex justify-between">
                    <p class="font-bold text-lg m-2">{{ $categoryName }}</p><div class="block m-2"><img src="{{ asset('img/edit.png') }}"></div>
                </div>
                <ul>
                    @foreach($resources as $resource)
                        <li class="bg-orange-400 rounded-lg p-5 m-2">{{ $resource['name'] }}</li>
                    @endforeach
                    
                    <div class="flex justify-center bg-orange-400 rounded-lg p-5 m-2">

                        <button data-modal-target="addResource" data-modal-toggle="addResource" class="block text-white bg-orange-400 focus:outline-none font-medium rounded-lg text-sm text-center" type="button">
                          <img src="{{ asset('img/mes.png') }}">
                        </button>
                    </div>
                      
                </ul>
            </div>
        @endforeach

            <div class="flex justify-center bg-orange-200 rounded-lg p-5 m-2">
                <button data-modal-target="addCategory" data-modal-toggle="addCategory" class="block text-white bg-orange-200 focus:outline-none font-medium rounded-lg text-sm text-center" type="button">    
                    <img src="{{ asset('img/mes.png') }}">
                </button>
            </div>
    </div>
</div>

</table>


<!-- Modal "addResource"-->

<!-- Main modal -->
<div id="addResource" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Añadir texto
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addResource">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="addResource" type="button" class="text-white bg-orange-400 hover:bg-gray-700 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-400 dark:hover:bg-gray-700">Añadir</button>
                <button data-modal-hide="addResource" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal "addCategory"-->

<!-- Main modal -->
<div id="addCategory" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-opacity-0">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Añade el nombre de la nueva categoría
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addResource">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form action="/categories" method="POST">
                  @csrf
                    <div class="mb-4">
                        <input type="text" id="name" name="name" class="border border-gray-400 p-2 w-full" required>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" data-modal-hide="addCategory" type="button" class="text-white bg-orange-400 hover:bg-gray-700 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-400 dark:hover:bg-gray-700">Añadir</button>
            </form>
                <button data-modal-hide="addCategory" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@stop