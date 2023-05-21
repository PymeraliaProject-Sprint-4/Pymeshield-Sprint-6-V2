<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 


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
