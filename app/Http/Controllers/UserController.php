<?php

namespace App\Http\Controllers;

use App\Models\User; // Assurez-vous que le modèle User est importé
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Affiche le formulaire de création d'un nouvel utilisateur.
     */
    public function create()
    {
        return view('users.create'); // Assurez-vous d'avoir une vue pour créer un utilisateur
    }

    /**
     * Stocke un nouvel utilisateur dans la base de données.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048', // Ajoutez la validation pour les fichiers images si nécessaire
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'cni' => 'required|integer',
            'role' => 'required|in:client,distributeur,agent',
            'mot_de_passe' => 'required|string|min:8|confirmed', // Validation du mot de passe
        ]);

        // Créer l'utilisateur
        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'photo' => $request->photo, // Gérez le téléchargement de fichiers si nécessaire
            'date_naissance' => $request->date_naissance,
            'adresse' => $request->adresse,
            'cni' => $request->cni,
            'role' => $request->role,
            'statut' => true, // Statut par défaut à actif
            'date_creation' => now(), // Date actuelle
            'mot_de_passe' => Hash::make($request->mot_de_passe), // Hachage du mot de passe
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('users.index', compact('users')); // Assurez-vous d'avoir une vue pour afficher la liste des utilisateurs
    }

    /**
     * Affiche le formulaire d'édition d'un utilisateur.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user')); // Assurez-vous d'avoir une vue pour éditer l'utilisateur
    }

    /**
     * Met à jour les informations d'un utilisateur.
     */
    public function update(Request $request, User $user)
    {
        // Valider les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'cni' => 'required|integer',
            'role' => 'required|in:client,distributeur,agent',
            'mot_de_passe' => 'nullable|string|min:8|confirmed', // Mot de passe peut être vide
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->telephone = $request->telephone;
        $user->photo = $request->photo; // Gérez le téléchargement de fichiers si nécessaire
        $user->date_naissance = $request->date_naissance;
        $user->adresse = $request->adresse;
        $user->cni = $request->cni;
        $user->role = $request->role;

        // Hachage du mot de passe si fourni
        if ($request->filled('mot_de_passe')) {
            $user->mot_de_passe = Hash::make($request->mot_de_passe);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }


    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public static function show($id){
        // Récupérer l'utilisateur par son ID
        $user = User::find($id);

        // Passer les données à la vue
        return $user;
    }
}
