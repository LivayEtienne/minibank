<?php

use Illuminate\Database\Seeder;
use App\Models\User; // Assurez-vous que le modèle User est dans ce namespace

class UserSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur
        $user = User::create([
            'nom' => 'John', // Remplacez par le champ approprié pour le nom
            'prenom' => 'Doe', // Remplacez par le champ approprié pour le prénom
            'telephone' => '1234567890', // Exemple de téléphone
            'email' => 'johndoe@example.com',
            'mot_de_passe' => bcrypt('secret'), // Utiliser le bon champ de mot de passe
            'adresse' => '10 Rue Exemple', // Exemple d'adresse
            'date_naissance' => '1990-01-01', // Exemple de date de naissance
            'cni' => '123456789', // Exemple de numéro de CNI
            'role' => 'agent', // Exemple de rôle
            'statut' => 1, // Exemple de statut actif
            'date_creation' => now(), // Valeur par défaut pour date de création
        ]);

        // Créer un compte associé à cet utilisateur
        $user->compte()->create([
            'solde' => 100.00, // Solde initial du compte
        ]);
    }
}
