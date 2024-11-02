<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['id_compte_source', 'id_compte_destinataire', 'id_distributeur', 'montant', 'type', 'frais'];

    // Relation avec le modèle Distributeur
    public function distributeur()
    {
        return $this->belongsTo(Distributeur::class, 'id_distributeur');
    }
}
