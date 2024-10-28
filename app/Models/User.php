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
        'email',
        'telephone',
        'photo',
        'date_naissance',
        'adresse',
        'cni',
        'role',
        'statut',
        'date_creation',
        'mot_de_passe',
        'archived',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // Définir les attributs en date ou temps si nécessaire
    protected $casts = [
        'date_naissance' => 'date',
        'statut' => 'boolean',
    ];



    
    // public function transactions(){
    //      $casts = [
    //         'date_naissance' => 'date',
    //         'email_verified_at' => 'datetime',
    //         'archived' => 'boolean',
    //     ];
    // }
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    public function scopeActive($query)
    {
        return $query->where('archived', false);
        //return $query->where('archived', false);
    }

    
    public function scopeFilterByRole($query, $role)
    {
        if ($role !== 'all') {
            return $query->where('role', $role);
        }

        return $query;
    }
}
