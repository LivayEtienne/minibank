<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_compte_source',
        'id_compte_destinataire',
        'id_distributeur',
        'montant',
        'type',
        'date',
        'frais',
        'statut',
    ];

    
    public function compteSource()
    {
        return $this->belongsTo(Client::class, 'id_compte_source', 'numero_compte');
    }

    public function compteDestinataire()
    {
        return $this->belongsTo(Client::class, 'id_compte_destinataire', 'numero_compte');
    }

    public function client()
    {
        // Supposons que id_compte_source fait référence à id dans le modèle Client
        return $this->belongsTo(Client::class, 'id_compte_source', 'id'); 
    }

    public function clientSource()
{
    return $this->belongsTo(Client::class, 'id_compte_source');
}

   public function clientDestinataire()
{
    return $this->belongsTo(Client::class, 'id_compte_destinataire');
}

    public function distributeur()
    {
        return $this->belongsTo(Agent::class, 'id_distributeur');
    }
}







