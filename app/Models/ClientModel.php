<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
 
    
    protected $table = 'clients'; // Spécifiez le nom de la table
    protected $fillable = ['id_user', 'solde', 'autres_colonnes']; // Ajoutez toutes les colonnes dont vous avez besoin
    
}

