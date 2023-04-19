<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    // retorna la vista login
    public function index()
    {
        return view('auth.login');
    }
    // retorna la vista recordar password
    public function rememberPassword()
    {
        return view('auth.lost_password');
    }
    // envía un link para recuperar password
    public function rememberSend(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);
        $request->validate([
            'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    // retornar la vista actualizar contraseña
    public function activateUser(Request $request): View
    {
        return view('auth.activate_user', ['request' => $request]);
    }
    // hacer login
    public function login(Request $request)
    {
        $request->validate([
            'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            if($user->type != 'worker'){
                return redirect('/home')->cookie('tokenBearer', $token, 180);
            }
            else{
                return redirect('/admin')->cookie('tokenBearer', $token, 180);
            }
        }

        return back()->withErrors([
            'email' => 'Email o contraseña incorrecta',
        ])->onlyInput('email');
    }

    public function loginPhone(Request $request)
    {
        $credentials = $request->only('email', 'password', 'company_id', 'type');

        if (Auth::guard('web')->attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('tokenBearer')->plainTextToken;
            $company_id = $user->company_id;
            $user_type = $user->type;

            return response()->json(['token' => $token, 'company_id' => $company_id, 'user_type' => $user_type]); //->cookie('tokenBearer', $token, 60)
        } else {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
    }


    // Guarda la contraseña si la reseteas
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => 'required|min:8|confirmed',
            'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
