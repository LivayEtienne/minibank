<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class distributeurModel extends Model
{
    protected $table = 'distributeurs'; // Remplacez par la table `distributeur`
    protected $fillable = ['id_user', 'solde', 'autres_colonnes']; // Ajoutez les colonnes nécessaires
}
