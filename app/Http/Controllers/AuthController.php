<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->user_role === 'superadmin') {
                return redirect()->route('superAdmin');

                /* All users of dashboard route are: admin, chefe_redacao, chefe_tecnico, chefe_emissoes */
            } elseif(in_array($user->user_role, [
                'admin',
                'chefeRedacao',
                'chefeTecnico',
                'chefeEmissoes']))
                {
                return redirect()->route('dashboard');
            }

            // User role not authorized, log out and redirect to login page with error message
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login0')
                ->withErrors([
                    'email' => 'O perfil deste utilizador não está autorizado.'
                ]);
        }

        // Email ou senha incorretos
        return redirect()
            ->route('login0')
            ->withErrors([
                'email' => 'Email ou palavra-passe incorretos.'
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('initial');
    }
}