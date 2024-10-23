<?php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'carte_identite' => 'required|string|max:50',
            'photo' => 'required|image|max:2048', // Limite de 2 Mo pour l'image
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'cni' => $request->carte_identite,
            'photo' => $request->file('photo')->store('photos', 'public'),
            'password' => Hash::make($request->password),
            'role' => 'user', // Par défaut, rôle "user"
            'statut' => 'actif',
            'date_creation' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Inscription réussie.');
    }
}
