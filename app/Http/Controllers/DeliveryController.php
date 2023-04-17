<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class DeliveryController extends Controller
{

    public function CursosCalificar()
    {
        return view('activity.indexProva');
    }

    public function courseActivities($id)
    {
        return view('activity.categorias_curso', compact('id'));
    }

    public function CursosCalificarDatos() //Acció per agarrar les dades de la BD
    {
        $courses = Course::get()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
            ];
        });
        return response()->json($courses);
    }

    public function courseActivitiesDatos($id) //Acció per agarrar les dades de la BD
    {
        // Obtener el nombre del curso y las categorías y actividades correspondientes del curso con el ID especificado
        $course = Course::findOrFail($id);
        $courseName = $course->name;
        $categories = $course->categories()->with('activities')->get();

        // Retornar los datos en formato JSON
        return response()->json([
            'courseName' => $courseName,
            'categories' => $categories,
        ]);
    }

    public function show($id, $activityId)
    {
        $course = Course::find($id);
        $activity = Activity::find($activityId);
        return view('activity.show', compact('course', 'activity'));
    }

    public function indexDatos($id, $activityId)
    {
        try {
            $postsperpage = 5;
            // Obtener los usuarios que pertenecen al curso seleccionado
            $users = DB::table('course_user')
                ->join('users', 'course_user.user_id', '=', 'users.id')
                ->where('course_id', $id)
                ->select('users.id', 'users.name')
                ->simplePaginate($postsperpage);

            $data = [];

            // Para cada usuario, obtener su entrega con activity_id = $activityId
            foreach ($users as $user) {
                $delivery = DB::table('deliveries')
                    ->where('user_id', $user->id)
                    ->where('activity_id', $activityId)
                    ->first();

                // Si el usuario tiene una entrega, recoger el id, mostrar el locate, grade y feedback
                if ($delivery) {
                    $data[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'locate' => $delivery->locate,
                        'grade' => $delivery->grade,
                        'feedback' => $delivery->feedback,
                    ];
                } else {
                    // Si el usuario no tiene una entrega, recoger el id y mostrar el nombre
                    $data[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'locate' => null,
                        'grade' => null,
                        'feedback' => null,
                    ];
                }
            }
            // Devolver los datos y la paginación como una respuesta JSON
            return response()->json($data);
        } catch (\Exception $e) {
            // Si hay una excepción, devolver un mensaje de error como respuesta JSON
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function qualify(Request $request, $activityId, $userId)
    {
        // Busca la entrega del usuario para la actividad
        $delivery = Delivery::where('activity_id', $activityId)
            ->where('user_id', $userId)
            ->first();
        if ($delivery) {
            // Si la entrega existe, actualiza los campos de grade y feedback
            $delivery->grade = $request->input('grade');
            $delivery->feedback = $request->input('feedback');
            $delivery->save();
        } else {
            // Si la entrega no existe, crea una nueva
            $delivery = new Delivery();
            $delivery->grade = $request->input('grade');
            $delivery->feedback = $request->input('feedback');
            $delivery->activity_id = $activityId;
            $delivery->user_id = $userId;
            $delivery->save();
        }

        // Retorna la entrega actualizada o creada
        return redirect()->back()->with('status', 'Entrega actualizada correctamente.');
    }
}
