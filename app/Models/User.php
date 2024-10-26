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
        'password',
    ];

    // Si vous utilisez des champs cachés, ajoutez-les ici
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Définir les attributs en date ou temps si nécessaire
    protected $casts = [
        'date_naissance' => 'date',
        'statut' => 'boolean',
    ];

    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_compte_source');
    }
}
