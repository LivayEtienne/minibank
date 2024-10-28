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
        'frais',
        'date',
    ];

    public function compteSource()
    {
        return $this->belongsTo(Client::class, 'id_compte_source');
    }

    public function compteDestinataire()
    {
        return $this->belongsTo(Client::class, 'id_compte_destinataire');
    }

    public function distributeur()
    {
        return $this->belongsTo(Distributeurs::class, 'id_distributeur');
    }
}
