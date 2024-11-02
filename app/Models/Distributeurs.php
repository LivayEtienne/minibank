<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distributeurs extends Model
{
    use HasFactory;
    // // Indique la table associée
    protected $table = 'distributeurs';

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'id_user', // Ajoutez cette ligne
        'numero_compte',
        'solde',
        'bonus',
        'created_at',
        'updated_at',
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
