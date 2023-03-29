@extends('layouts.user')

@section('content')
<div id="app">
  <h1 style= "margin-left: 20px; margin-top: 20px;" class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
    class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">Localización</span> </span> y calendario </h1>

<mapa-pymeralia/>
</div>


@endsection
