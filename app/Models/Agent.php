<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    // Indique la table associée
    protected $table = 'agents';

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'id_user',
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}