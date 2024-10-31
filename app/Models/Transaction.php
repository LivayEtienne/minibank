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
    ];

    
    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'id_compte_source', 'id');
    }

    public function destinationUser()
    {
        return $this->belongsTo(User::class, 'id_compte_destinataire', 'id');
    }
}


