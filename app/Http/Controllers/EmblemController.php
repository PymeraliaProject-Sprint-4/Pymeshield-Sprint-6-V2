<?php

namespace App\Http\Controllers;

use App\Models\Emblem;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
use App\Models\Course;
use Illuminate\Support\Carbon;
use Illuminate\Pagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmblemController extends Controller
{
    public function index()
    {
        $emblems = Emblem::with('course')->orderby('id', 'desc')->whereNull('hidden')->paginate(10);
        $courses = Course::all();

        return view('emblems.emblemes', compact('emblems', 'courses'));
        
    }


    public function mostrar()
    {
        $emblems = Emblem::with('course')->orderby('id', 'desc')->whereNull('hidden')->paginate(10);
        $courses = Course::all();
    
        return response()->json([
            'emblems' => $emblems,
            'courses' => $courses,
        ]);
    }


    public function create (){

        $courses = Course::all();
        return view('emblems.emblemescrear', compact('courses'));

    }

    public function store(Request $request)
{
    $emblem = new Emblem;
   // dd($request->file('image'));

    $emblem->name = $request->name;
    $emblem->description = $request->description;

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    
    if($request->file('image')){
        $image = $request->file('image');
        $path = 'img/imatgesemblemes/';
        $filename = time() . '.' . $image->getClientOriginalName();
        $guardar = $request->file('image')->move($path, $filename);
        //dd($guardar);
        $emblem->image = $path . $filename;
    }

    $emblem->course_id = $request->course_id;

    $emblem->save();
    
    return redirect()->route('emblems.index');
}

    public function edit (Emblem $emblem){

        $courses = Course::all();
        return view('emblems.emblemesedit', compact('emblem', 'courses'));

    }

    public function update(Request $request, Emblem $emblem)
{

    // Actualiza los campos de texto
    $emblem->name = $request->name;
    $emblem->description = $request->descripcion;
    $emblem->course_id = $request->course_id;

    // Guarda los cambios en la base de datos
    $emblem->save();

    return redirect()->route('emblems.index');
}

    public function restaurar()
    {
        $emblems = Emblem::whereNotNull('hidden')->orderBy('id', 'desc')->paginate(10);

        return view('emblems.restaurar', compact('emblems'));
        
    }

    public function restaurarMostrar()
    {
        $emblems = Emblem::whereNotNull('hidden')->orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'emblems' => $emblems,
        ]);
        
    }

    public function restaurarhide($emblem)
    {
        
        $emblem = Emblem::find($emblem);
        $emblem->hidden = null;
        $emblem->save();

        return back();
    }

    public function DadesActivitats() //Acció per agarrar les dades de la BD
    {
        $activity = Activity::get()->map(function ($activity) {
            return [
                'id' => $activity->id,
                'name' => $activity->name,
            ];
        });
        return response()->json($activity);
    }

    public function eliminar($emblem)
    {
        $emblem = Emblem::find($emblem);
        $emblem->hidden = Carbon::now()->format('Y-m-d');
        $emblem->save();

        $emblem = Emblem::whereNull('hidden')->orderBy('updated_at', 'desc')->get();
        
        return back();
    }
    
}
