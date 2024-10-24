<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'telephone' => '779453064',
            'photo' => 'path/to/photo.jpg',
            'date_naissance' => '1990-01-01',
            'adresse' => '10 Rue de Paris',
            'cni' => '123456789',
            'role' => 'agent',
            'statut' => true,
            'mot_de_passe' => bcrypt('aldiey@'),
        ]);

        User::create([
            'nom' => 'Martin',
            'prenom' => 'Sophie',
            'telephone' => '709874561',
            'photo' => 'path/to/photo.jpg',
            'date_naissance' => '1985-05-20',
            'adresse' => '20 Avenue de Lyon',
            'cni' => '987654321',
            'role' => 'distributeur',
            'statut' => true,
            'mot_de_passe' => bcrypt('aldiey@'),
        ]);

        User::create([
            'nom' => 'Ndiaye',
            'prenom' => 'Sophie',
            'telephone' => '773028756',
            'photo' => 'path/to/photo.jpg',
            'date_naissance' => '1985-05-20',
            'adresse' => '20 Avenue de Lyon',
            'cni' => '987654321',
            'role' => 'client',
            'statut' => true,
            'mot_de_passe' => bcrypt('aldiey@'),
        ]);
    }
}
