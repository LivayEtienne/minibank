<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Authentification de l'utilisateur

        $request->session()->regenerate(); // Regénérer la session pour éviter les attaques de fixation de session

        $user = Auth::user(); // Récupérer l'utilisateur authentifié

        // Rediriger en fonction du rôle
        switch ($user->role) {
            case 'agent':
                return redirect()->route('agent/dashboard'); // Redirection vers le tableau de bord agent
            case 'client':
                return redirect()->route('client.dashboard'); // Redirection vers le tableau de bord client
            case 'distributeur':
                return redirect()->route('distributeur.dashboard'); // Redirection vers le tableau de bord distributeur
            default:
                return redirect()->intended('home'); // Redirection par défaut
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
}