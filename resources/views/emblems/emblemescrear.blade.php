@extends('layouts.admin')

@section('content')  

    <!-- MODAL CREAR -->
    <div>
      <h1 class="font-bold">Crear Emblema</h1>
    </div><br>
    
    <form method="POST" action="{{route('emblems.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" name="name" id="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
        </div>
        <div>
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
            <input type="text" name="description" id="description"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
        </div>
        <div>
        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Emblema:</label>
        <input type="file" name="image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
        </div>
        <div>
          <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Curso:</label>
            <select name="course_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
              <option value="">Selecciona un Curso</option>
              @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
              @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.707,7.293c0.391,0.391,0.391,1.023,0,1.414l-3.5,3.5c-0.391,0.391-1.023,0.391-1.414,0l-3.5-3.5 c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0L10,10.586L14.293,6.293C14.488,6.098,14.744,6,15,6 C15.256,6,15.512,6.098,15.707,6.293S16,6.744,16,7C16,7.256,15.902,7.512,15.707,7.707L14.707,7.293z"/>
              </svg>
            </div>
          </div>
          <br>
          <div class="flex justify-center mt-4">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Crear
            </button>
        </div>
      </form>
@stop