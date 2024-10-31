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
        // Validation des données entrantes
        $validatedData = $request->validate([
            'prenom' => ['required', 'string', 'max:255', 'regex:/^[\S]+(\s[\S]+)*$/'],
            'nom' => ['required', 'string', 'max:255', 'regex:/^[\S]+(\s[\S]+)*$/'],
            'telephone' => 'required|string|max:15',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'cni' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^[A-Za-z0-9@]+$/',
                'confirmed',
            ],
            'role' => 'required|in:client,administrateur',
        ]);
    
        // Gestion du téléchargement de la photo
        $photoPath = null;
    
        if ($request->hasFile('photo')) {
            $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('photos'), $fileName);
            $photoPath = 'photos/' . $fileName;
        }
    
        // Création de l'utilisateur
        User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'date_naissance' => $validatedData['date_naissance'],
            'telephone' => $validatedData['telephone'],
            'adresse' => $validatedData['adresse'],
            'role' => $validatedData['role'],
            'statut' => 0,
            'password' => Hash::make($validatedData['mot_de_passe']),
            'cni' => $validatedData['cni'], // Conserver le type de données string
            'date_creation' => now(),
            'photo' => $photoPath,
        ]);
        
        // Redirection ou réponse après la création avec un message de succès
        return redirect()->back()->with('success', 'Utilisateur créé avec succès.');
    }

}
