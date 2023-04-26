<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.index');
    }

    public function coursecategories()
    {
        return view('course.coursecategories');
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

    public function index_data_categories()
    {
        $postsperpage = 7;
        return Category::select('categories.id', 'categories.name', 'categories.course_id', 'courses.name as course_name')
            ->join('courses', 'categories.course_id', '=', 'courses.id')
            ->orderBy('categories.updated_at', 'desc')
            ->paginate($postsperpage);
    }

    public function allCourses()
    {
        return Course::whereNull('hidden')
            ->get();
    }

    public function CategoryDelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
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
        $courseId = $course->id;
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
            'id' => $courseId,
            'courses' => $courses,
        ]);
    }

    public function createCategory(Request $request)
    {

        // Guardar la nueva categoría en la base de datos
        $currentTime = Carbon::now();

        $category = new Category;
        $category->name = $request->name;
        $category->course_id = $request->selectedCourse; // agregando la relación con el curso seleccionado
        $category->hidden = $currentTime->toDateTimeString();
        $category->created_at = now();
        $category->save();

        return response()->json(['message' => 'Categoría creada'], 200);
    }

    public function updateCategory($id, Request $request)
    {
        $category = Category::find($id);
        $category->name = strip_tags($request->name_edit);
        $category->course_id = $request->selectedCourse;
        $category->save();
        return response()->json(['courses' => $category->course]);
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
        $courseId = $course->id;

        $courses =  Course::whereNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();

        return response()->json([
            'id' => $courseId,
            'courses' => $courses,
        ]);
    }

    public function unHide($id)
    {
        $course = Course::find($id);
        $course->hidden = null;
        $course->save();
        $courseId = $course->id;

        $courses =  Course::whereNotNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->with(['users' => function ($query) {
                $query->select('user_id');
            }])
            ->get();
        return response()->json([
            'id' => $courseId,
            'courses' => $courses,
        ]);
    }

    public function update($id, Request $request)
    {
        $course = Course::find($id);
        $course->name = strip_tags($request->name_edit);
        $course->description = strip_tags($request->description_edit);
        $course->save();
        $courseId = $course->id;

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
            'id' => $courseId,
            'courses' => $courses,
        ]);
    }

    public function update_hidden($id, Request $request)
    {
        $course = Course::find($id);
        $course->name = strip_tags($request->name_edit);
        $course->description = strip_tags($request->description_edit);
        $course->save();
        $courseId = $course->id;

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
            'id' => $courseId,
            'courses' => $courses,
        ]);
    }

    public function course_User()
    {
        if (auth()->user()->type == 'client') {
            $data = DB::table('course_user')
                ->join('courses', 'courses.id', '=', 'course_user.course_id')
                ->select('courses.id', 'courses.name', 'courses.description')
                ->where('user_id', '=', auth()->user()->id)
                ->groupBy('courses.id', 'courses.name', 'courses.description', 'course_user.updated_at')
                ->get();

            return response()->json($data);
        } else {
            $data = DB::table('course_user')
                ->join('courses', 'courses.id', '=', 'course_user.course_id')
                ->select('courses.id', 'courses.name', 'courses.description')
                ->groupBy('courses.id', 'courses.name', 'courses.description', 'course_user.updated_at')
                ->get();

            return response()->json($data);
        }
    }
}
