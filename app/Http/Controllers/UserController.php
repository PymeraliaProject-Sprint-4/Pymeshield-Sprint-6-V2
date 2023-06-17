<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Robot;


class UserController extends Controller
{
    // API
    public function indexAPI()
    {
        $users = User::all()->where('id', '=', auth()->user()->id);
        return response()->json($users);
    }

    //User
    public function show_user()
    {
        return view('Mio.Es_Mio');
    }

    public function TransferUsers()
    {
        $loggedInUserId = Auth::id();

        $users = DB::table('users')
            ->join('billetera', 'users.id', '=', 'billetera.user_id')
            ->where('users.id', '!=', $loggedInUserId)
            ->select('users.*', 'billetera.id as billetera_id', 'billetera.public_key', 'billetera.private_key', 'billetera.direccion')
            ->get();

        return $users;
    }

    public function view_comercio()
    {
        return view('comercio.show');
    }

    public function robots()
    {
        return view('robots.show');
    }

    public function saveRobot(Request $request)
    {
        // Obtener el nombre del robot del formulario
        $robotName = $request->input('robotName');

        // Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // Crear un nuevo registro de robot en la base de datos
        $robot = new Robot;
        $robot->Name_robot = $robotName;
        $robot->user_id = $userId;
        $robot->save();

        // Respuesta exitosa
        return response()->json(['message' => 'Robot guardado exitosamente']);
    }

    public function allRobots()
    {
        $user = Auth::user();

        $robots = DB::table('robots')
            ->where('user_id', $user->id)
            ->select('id', 'Name_robot')
            ->get();

        return response()->json($robots);
    }


    public function contacte()
    {
        return view('contacte.contacte');
    }
    public function userInfo()
    {
        $user = Auth::user();
        $userInfo = DB::table('users')
            ->join('billetera', 'users.id', '=', 'billetera.user_id')
            ->where('users.id', $user->id)
            ->select(
                'users.id',
                'users.name',
                'users.last_name',
                'users.nick_name',
                'users.direccion_billetera_binance',
                'users.payment_password',
                'billetera.public_key',
                'billetera.private_key',
                'billetera.direccion'
            )
            ->first();

        return response()->json($userInfo);
    }

    public function saveWallet(Request $request)
    {
        // Validar la solicitud y asegurarse de que se proporcionó una dirección de billetera
        $request->validate([
            'walletAddress' => 'required'
        ]);

        // Obtener el usuario autenticado (puedes ajustar esto según tu lógica de autenticación)
        $userId = auth()->user()->id;

        // Actualizar la dirección de la billetera en la tabla de usuarios
        DB::table('users')->where('id', $userId)->update([
            'direccion_billetera_binance' => $request->walletAddress
        ]);

        // Puedes agregar cualquier lógica adicional aquí después de guardar la dirección de la billetera

        // Devolver una respuesta de éxito (puedes ajustar esto según tus necesidades)
        return response()->json(['message' => 'La dirección de la billetera se guardó correctamente']);
    }


    public function deleteWallet()
    {
        // Obtener el usuario autenticado (puedes ajustar esto según tu lógica de autenticación)
        $user = auth()->user();

        // Actualizar el campo "direccion_billetera_binance" a NULL utilizando una consulta directa en la base de datos
        DB::table('users')->where('id', $user->id)->update(['direccion_billetera_binance' => null]);

        // Puedes agregar cualquier lógica adicional aquí después de eliminar la dirección de la billetera

        // Devolver una respuesta de éxito (puedes ajustar esto según tus necesidades)
        return response()->json(['message' => 'La dirección de la billetera se eliminó correctamente']);
    }

    public function PaymentPassword(Request $request)
    {
        // Validar la solicitud y asegurarse de que se proporcionó una contraseña de pago
        $request->validate([
            'password' => 'required'
        ]);

        // Obtener el usuario autenticado (puedes ajustar esto según tu lógica de autenticación)
        $user = auth()->user();

        // Encriptar la contraseña de pago
        $encryptedPassword = Hash::make($request->password);

        // Actualizar la contraseña encriptada en la base de datos
        DB::table('users')
            ->where('id', $user->id)
            ->update(['payment_password' => $encryptedPassword]);

        // Puedes agregar cualquier lógica adicional aquí después de actualizar la contraseña de pago

        // Devolver una respuesta de éxito (puedes ajustar esto según tus necesidades)
        return response()->json(['message' => 'La contraseña de pago se guardó correctamente']);
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
}
