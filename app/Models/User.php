<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Les attributs pouvant être assignés en masse
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
        'date_creation',
        'password',
    ];

    // Attributs masqués pour la conversion en tableau et en JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relation avec le modèle Client
    public function clients()
    {
        return $this->hasMany(Client::class, 'id_user');
    }

    
    public function distributeur()
    {
        return $this->hasOne(Distributeur::class, 'id_user');
    }
}
