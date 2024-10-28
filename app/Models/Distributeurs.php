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
        'numero_compte',
        'id_user',
        'solde',
        'bonus',
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
