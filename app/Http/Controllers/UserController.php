<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\DeviceUser;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Agrega esta línea
use App\Models\Company;
use App\Models\Device;
use Carbon\Carbon;
use Password;
use Str;

class UserController extends Controller
{
    // API
    public function indexAPI()
    {
        $users = User::all()->where('id', '=', auth()->user()->id);
        return response()->json($users);
    }

    //Admin
    public function userList()
    {
        return view('users.list_of_users');
    }

    public function userListhidden()
    {
        return view('users.list_of_hidden_users');
    }

    public function userListingHidden()
    {
        $userInfo = DB::table('users')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name AS company_name')
            ->whereNotNull('users.hidden')
            ->get();
        return $userInfo;
    }

    public function unHideUser($id)
    {
        $user = User::find($id);
        $user->hidden = null;
        $user->save();
        $userId = $user->id;

        $user =  User::whereNotNull('hidden')
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json([
            'id' => $userId,
            'users' => $user,
        ]);
    }

    public function userListing()
    {
        $postsPerPage = 7;
        $userInfo = DB::table('users')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name AS company_name')
            ->whereNull('users.hidden')
            ->orderByRaw("CASE WHEN users.type = 'admin' THEN 1 ELSE 2 END, users.type ASC")
            ->paginate($postsPerPage);

        return response()->json($userInfo);
    }


    public function userListingWorker()
    {
        $postsPerPage = 7;
        $userInfo = DB::table('users')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name AS company_name')
            ->whereNull('users.hidden')
            ->orderByRaw("CASE WHEN users.type = 'worker' THEN 1 ELSE 2 END, users.type ASC")
            ->paginate($postsPerPage);

        return response()->json($userInfo);
    }

    public function userListingClient()
    {
        $postsPerPage = 7;
        $userInfo = DB::table('users')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name AS company_name')
            ->whereNull('users.hidden')
            ->orderByRaw("CASE WHEN users.type = 'client' THEN 1 ELSE 2 END, users.type ASC")
            ->paginate($postsPerPage);

        return response()->json($userInfo);
    }



    // Agrega un usuario ADMIN
    public function addUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->nick_name = $request->nick_name;
        $user->email = $request->email;
        $user->password = Hash::make(Str::random(14));
        $user->phone = $request->phone;
        $user->company_id = $request->selectedCompany;
        $user->type = $request->selectedType;
        $user->save();

        // se le envía un email para que pueda poner una contraseña
        Password::sendResetLink(
            ['email' => $request->email]
        );

        return response()->json(['success' => true, 'message' => 'User created successfully.']);
    }

    //Editar usuario ADMIN
    public function editUser(Request $request)
    {
        $user = User::find($request->id); // para que coja el id de la tabla
        $company = Company::find($user->company_id); // Obtén el modelo de la compañía
        $requestData = $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'nick_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string',
            'company_name' => 'required|string',
            'type' => 'required|string'
        ]);

        $user->name = $requestData['name'];
        $user->last_name = $requestData['last_name'];
        $user->nick_name = $requestData['nick_name'];
        $user->phone = $requestData['phone'];
        $user->type = $requestData['type'];
        $company->name = $requestData['company_name'];
        if ($user->email != $requestData['email']) {
            $user->email = $requestData['email'];
            $user->update();
            // se le envía la contraseña al nuevo email
            Password::sendResetLink(
                ['email' => $request->email]
            );
        } else {
            $company->update();
            $user->update();
        }
    }

    // Baja usuario ADMIN
    public function userDown(Request $request)
    {
        $request->validate([
            'removed_reason' => 'nullable|max:255|string',
        ]);
        $currentTime = Carbon::now();
        $user = User::findOrFail($request->id); // Busca el usuario por su ID
        $user->removed_reason = $request->removed_reason;
        $user->hidden = $currentTime->toDateTimeString();
        $user->update(); // Actualiza los datos en la base de datos
    }

    public function unsuscribeCompany(Request $request)
    {
        $request->validate([
            'removed_reason' => 'nullable|max:255|string',
        ]);

        $currentTime = Carbon::now();


        $company = Company::findOrFail($request->id);
        $company->removed_reason =  $request->removed_reason;
        $company->hidden = $currentTime->toDateTimeString();
        $company->update();
    }

    //User
    public function show_user()
    {
        return view('perfilPersonal.perfil_personal');
    }
    public function show_user_admin()
    {
        return view('perfilPersonal.perfil_personal_admin');
    }
    public function show_user_worker()
    {
        return view('perfilPersonal.perfil_personal_worker');
    }

    public function contacte()
    {
        return view('contacte.contacte');
    }

    public function EditarPerfilAdmin()
    {
        return view('perfilPersonal.EditarPerfilAdmin');
    }

    public function EditarPerfilWorker()
    {
        return view('perfilPersonal.EditarPerfilWorker');
    }
    //Funcion para editar la info del usuario admin

    public function updateUserAdmin(Request $request)
    {
        $authenticatedUser = Auth::user();
        $updatedUser = User::find($authenticatedUser->id);

        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'nick_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $updatedUser->name = $request->input('name');
        $updatedUser->last_name = $request->input('last_name');
        $updatedUser->nick_name = $request->input('nick_name');
        $updatedUser->email = $request->input('email');
        $updatedUser->phone = $request->input('phone');

        $updatedUser->save();

        return redirect()->route('Editar-Perfil')->with('success', 'Información actualizada con éxito');
    }

    public function updateUserWorker(Request $request)
    {
        $authenticatedUser = Auth::user();
        $updatedUser = User::find($authenticatedUser->id);

        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'nick_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $updatedUser->name = $request->input('name');
        $updatedUser->last_name = $request->input('last_name');
        $updatedUser->nick_name = $request->input('nick_name');
        $updatedUser->email = $request->input('email');
        $updatedUser->phone = $request->input('phone');

        $updatedUser->save();

        return redirect()->route('Editar-Perfil')->with('success', 'Información actualizada con éxito');
    }



    public function userInfo()
    {
        $user = Auth::user();
        $userInfo = DB::table('users')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name AS company_name')
            ->where('users.id', '=', $user->id)
            ->first();

        $userEmblem = DB::table('users')
            ->join('course_user', 'users.id', '=', 'course_user.user_id')
            ->join('emblems', 'emblems.course_id', '=', 'course_user.course_id')
            ->select('users.*', 'course_user.course_id', 'emblems.id AS emblem_id', 'emblems.name AS emblem_name', 'emblems.image')
            ->where('users.id', '=', $user->id)
            ->get();

        return[
            'userEmblem' => $userEmblem,
            'userInfo' => $userInfo
        ];
    }

    public function editarUsuario()
    {
        $authenticatedUser = Auth::user();
        $authenticatedUser = DB::table('users')
            ->join('companies', 'users.company_id', '=', 'companies.id')
            ->select('users.*', 'companies.name AS company_name')
            ->where('users.id', '=', $authenticatedUser->id)
            ->first();
        return view('perfilPersonal.EditarPerfil', compact('authenticatedUser'));
    }

    public function updateProfile(Request $request)
    {
        $authenticatedUser = Auth::user();
        $updatedUser = User::find($authenticatedUser->id);

        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'nick_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $updatedUser->name = $request->input('name');
        $updatedUser->last_name = $request->input('last_name');
        $updatedUser->nick_name = $request->input('nick_name');
        $updatedUser->email = $request->input('email');
        $updatedUser->phone = $request->input('phone');

        $updatedUser->save();

        return redirect()->route('Editar-Perfil');
    }

    public function updateProfileImage(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        // Validar la imagen
        $request->validate([
            'profile_image' => 'image|max:2048',
        ]);

        // Procesar la imagen
        $image = $request->file('profile_image');
        $imageName = $image->getClientOriginalName();

        // Mover la imagen a la carpeta "public/img/profile_images"
        $image->move(public_path('img/profile_images'), $imageName);

        // Guardar el nombre de la imagen en la base de datos
        $user->update([
            'profile_image' => $imageName,
        ]);

        return redirect()->route('Editar-Perfil');
    }
    public function delete(Request $request)
    {
        $user = $request->user();

        // Eliminar la imagen anterior si existe
        if ($user->profile_image) {
            $image_path = storage_path('app/public/profile_images/' . $user->profile_image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $user->profile_image = null; // Asignar valor nulo al campo profile_image
        }

        // Actualizar el campo de la imagen del usuario
        $user->save();

        return redirect()->route('Editar-Perfil');
    }

    public function changePassword(Request $request)
    {
        // Obtener los datos enviados por el formulario
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Encriptar las contraseñas
        $currentPasswordHashed = Hash::make($currentPassword);
        $newPasswordHashed = Hash::make($newPassword);
        $confirmPasswordHashed = Hash::make($confirmPassword);

        // Validar que la contraseña actual sea correcta
        if (!Hash::check($currentPassword, $user->password)) {
            return redirect()->route('Editar-Perfil');
        }

        // Validar que la nueva contraseña y su confirmación coincidan
        if ($newPassword !== $confirmPassword) {
            return redirect()->route('Editar-Perfil');
        }

        // Cambiar la contraseña del usuario
        $user->password = $newPasswordHashed;
        User::where('id', $user->id)->update(['password' => $newPasswordHashed]);

        // Redirigir al usuario a la página de perfil con un mensaje de éxito
        return redirect()->route('Personal-Profile')->with('success', 'La contraseña ha sido cambiada correctamente.');
    }

    public function switchLanguage($locale)
    {
        session()->put('locale', $locale);
        return redirect()->back();
    }

    /**
     * dashboardUser retorna la vista del dashboard del usuario Cliente
     *
     * @return void
     */
    public function dashboardUser()
    {
        return view('users.dashboardUser');
    }

    /**
     * oneMonthTaskLimit retorna las tareas que aún no estan echas, no estan ocultas
     * y le faltan 1 mes para caducar filtradas por el usuario de la sesión.
     *
     * @return response Json
     */
    public function oneMonthTaskLimit()
    {
        $user_id = Auth::id();

        $tasks = Task::where('user_id', $user_id)
            ->select('tasks.id', 'tasks.state', 'tasks.final_date', 'answers.recommendation', 'impacts.name')
            ->join('answers', 'tasks.answer_id', '=', 'answers.id')
            ->join('impacts', 'answers.impact_id', '=', 'impacts.id')
            ->where('state', '!=', 'Done')
            ->whereBetween('tasks.final_date', [now(), now()->addWeeks(4)])
            ->whereNull('tasks.hidden')
            ->get();

        return response()->json($tasks);
    }

    /**
     * assignedCoursesUser muestra los cursos que esta cursando el cliente.
     *
     * @return response Json
     */
    public function assignedCoursesUser()
    {

        $user_id = Auth::id();

        $activities = Course::where('user_id', $user_id)
            ->select('courses.name', 'courses.image', 'categories.name as categoryName', 'activities.name as activityName', 'activities.final_date', 'courses.id')
            ->join('course_user', 'courses.id', '=', 'course_user.course_id')
            ->join('categories', 'courses.id', '=', 'categories.course_id')
            ->join('activities', 'categories.id', '=', 'activities.category_id')
            ->whereBetween('activities.final_date', [now(), now()->addWeeks(4)])
            ->whereNull('courses.hidden')
            ->get();

        return response()->json($activities);
    }

    /**
     * graphicUserData
     *
     * Acción que retorna un array JSON con los datos de total de dispositivos, cursos y tareas
     * que tiene el usuario
     *
     * @return void
     */
    public function graphicUserData()
    {

        $user_id = Auth::id();
        $company_id = Auth::user()->company_id;

        $countDevices = Device::where('company_id', $company_id)
            ->select(DB::raw("COUNT(*) as num_devices"))
            ->Where('state', '!=', 'Deshabilitado')
            ->get();

        $countCourses = CourseUser::where('user_id', $user_id)
            ->select(DB::raw("COUNT(*) as num_courses"))
            ->get();

        $countTasks = Task::where('user_id', $user_id)
            ->select(DB::raw("COUNT(*) as num_tasks"))
            ->whereNull('tasks.hidden')
            ->where('state', '!=', 'Done')
            ->get();

        if ($countDevices[0]->num_devices == 0 && $countCourses[0]->num_courses == 0 && $countTasks[0]->num_tasks == 0) {
            return null;
        }

        return response()->json(['countDevices' => $countDevices, 'countCourses' => $countCourses, 'countTasks' => $countTasks]);
    }

    public function allUsers()
    {
        return User::all();
    }

    public function graphicAdminData()
    {

        $countDevices = DeviceUser::count();

        $countCourses = CourseUser::count();

        $countCompanies = Company::count();

        $countUsers = User::count();

        if ($countDevices == 0 && $countCourses == 0 && $countCompanies == 0 && $countUsers == 0) {
            return null;
        }

        return response()->json(['countDevices' => $countDevices, 'countCourses' => $countCourses, 'countCompanies' => $countCompanies, 'countUsers' => $countUsers]);
    }
}
