<?php
// App\Models\Agent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['nom', 'prenom', 'numero_telephone', 'adresse', 'numero_carte_identite'];

    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

// App\Models\Compte.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    protected $fillable = ['numero_compte', 'solde', 'etat', 'qrcode', 'type', 'client_id', 'distributeur_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function distributeur()
    {
        return $this->belongsTo(Distributeur::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

// App\Models\Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['type', 'montant', 'compte_id', 'statut', 'frais', 'commission'];

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
}
