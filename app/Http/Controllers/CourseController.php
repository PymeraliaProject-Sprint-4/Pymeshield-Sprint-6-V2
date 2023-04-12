<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.index');
    }

    public function index_data()
    {
        return Course::whereNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();
    }

    public function users()
    {
        return User::whereNull('hidden')->orderBy('updated_at', 'desc')->get();
    }

    public function hidden()
    {
        return view('course.hidden');
    }

    public function hidden_data()
    {
        return Course::whereNotNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();
    }

    public function index_client()
    {
        $cursos = Course::whereNull('hidden')->orderBy('updated_at', 'desc')->get();

        return view('course.client.index', compact('cursos'));
    }

    public function client_data()
    {
        return Course::whereNull('hidden')->orderBy('updated_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        // Guardar el nuevo curso en la base de datos
        $course = new Course;
        $course->name = strip_tags($request->name);
        $course->description = strip_tags($request->description);
        $course->created_at = now();
        $course->save();

        // Obtener los ids de los usuarios del array $request->users
        $userIds = $request->selectedUsers;

        // Crear registros en la tabla course_user para cada usuario del curso
        foreach ($userIds as $userId) {
            $courseUser = new CourseUser;
            $courseUser->course_id = $course->id;
            $courseUser->user_id = $userId;
            $courseUser->save();
        }

        // Obtener todos los cursos para actualizar la tabla
        $courses =  Course::whereNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();

        // Devolver los cursos actualizados en formato JSON
        return response()->json([
            'courses' => $courses,
        ]);
    }



    public function restore($id)
    {
        $course = Course::find($id);
        $course->update(['hidden' => NULL]);
        return back()->with('success', 'Curso recuperado con éxito');
    }


    public function hide($id)
    {
        $course = Course::find($id);
        $course->hidden = Carbon::now()->format('Y-m-d');
        $course->save();

        $courses =  Course::whereNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();

        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function unHide($id)
    {
        $course = Course::find($id);
        $course->hidden = null;
        $course->save();

        $courses =  Course::whereNotNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();
        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function update($id, Request $request)
    {
        $course = Course::find($id);
        $course->name = strip_tags($request->name_edit);
        $course->description = strip_tags($request->description_edit);
        $course->save();

        $userIds = $request->selectedUsers;

        // Crear registros en la tabla course_user para cada usuario del curso
        foreach ($userIds as $userId) {
            if (isset($userId)) {
                $courseUser = new CourseUser;
                $courseUser->course_id = $course->id;
                $courseUser->user_id = $userId;
                $courseUser->save();
            }
        }

        $course->users()->sync($userIds);

        // Obtener todos los cursos para actualizar la tabla
        $courses =  Course::whereNull('hidden')
        ->orderBy('updated_at', 'desc')
        ->with(['users' => function ($query) {
            $query->select('user_id');
        }])
        ->get();

        // Devolver los cursos actualizados en formato JSON
        return response()->json([
            'courses' => $courses,
        ]);
    }

    public function update_hidden($id, Request $request)
    {
        $course = Course::find($id);
        $course->name = strip_tags($request->name_edit);
        $course->description = strip_tags($request->description_edit);
        $course->save();

        $userIds = $request->selectedUsers;

        // Crear registros en la tabla course_user para cada usuario del curso
        foreach ($userIds as $userId) {
            if (isset($userId)) {
                $courseUser = new CourseUser;
                $courseUser->course_id = $course->id;
                $courseUser->user_id = $userId;
                $courseUser->save();
            }
        }

        $course->users()->sync($userIds);

        // Obtener todos los cursos para actualizar la tabla
        $courses =  Course::whereNotNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();

        // Devolver los cursos actualizados en formato JSON
        return response()->json([
            'courses' => $courses,
        ]);
    }


}



