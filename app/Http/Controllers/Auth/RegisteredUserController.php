<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // Pour manipuler les fichiers

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register'); // Vue pour le formulaire d'inscription
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prenom' => ['required', 'string', 'max:255', 'regex:/^[\S]+(\s[\S]+)*$/'],
            'nom' => ['required', 'string', 'max:255', 'regex:/^[\S]+(\s[\S]+)*$/'],
            'telephone' => 'required|string|max:15',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'cni' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mot_de_passe' => [
                'required',
                'string',
                'min:8',
                'regex:/^[A-Za-z0-9@]+$/',
                'confirmed',
            ],
            'role' => 'required|in:client,distributeur',
        ]);

        // Gestion du téléchargement de la photo
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('photos'), $fileName);
            $photoPath = 'photos/' . $fileName;
        }

        $validatedData['photo'] = $photoPath;

        // Création de l'utilisateur
        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => $request->role,
            'cni' => (int)$request->cni,
            'date_creation' => now(),
            'photo' => $photoPath,
        ]);

        // Redirection ou réponse après la création avec un message de succès
        return redirect()->route('register')->with('success', 'Utilisateur créé avec succès.');
    }

}
