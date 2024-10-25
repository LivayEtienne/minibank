<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    // Si la table s'appelle 'clients', tu n'as pas besoin de spécifier le nom.
    protected $table = 'transactions';

    protected $fillable = ['id', 'date', 'montant'];
    
}

