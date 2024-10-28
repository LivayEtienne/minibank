<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.connexion'); // Assurez-vous d'avoir une vue 'auth.connexion'
    }

    public function login(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Récupération des informations d'identification
        $credentials = $request->only('email', 'password');

        // Tentative d'authentification
        if (Auth::attempt($credentials)) {
            // Authentification réussie
            return redirect()->intended('dashboard'); // Redirection vers la destination prévue
        }

        // Authentification échouée
        return redirect()->back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ]);
    }
}
