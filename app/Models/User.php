<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'photo',
        'date_naissance',
        'adresse',
        'cni',
        'role',
        'statut',
        'mot_de_passe',
    ];

    // Si vous utilisez des champs cachés, ajoutez-les ici
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // Définir les attributs en date ou temps si nécessaire
    protected $casts = [
        'date_naissance' => 'date',
        'statut' => 'boolean',
    ];

    // Vous pouvez ajouter d'autres méthodes si nécessaire
}
