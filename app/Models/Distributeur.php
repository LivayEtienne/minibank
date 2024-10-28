<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distributeur extends Model
{
    use HasFactory;

    protected $table = 'distributeurs';
    
    // Indique si le modèle utilise des timestamps (created_at et updated_at)
    public $timestamps = true;

    // Les attributs qui peuvent être remplis
    protected $fillable = [
        'nom',
        'solde',
        'bonus',
    ];

    protected $casts = [
        'solde' => 'decimal:2'  // Précision de 2 décimales
    ];

   
}