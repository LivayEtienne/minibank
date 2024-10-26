<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_compte',
        'solde',
        'id_user',
        'nom', 
        'prenom',
         'telephone',
    ];

    /**
     * Get the user that owns the client.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the transactions for the client.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, );
    }

    /**
     * Deposit amount to the client's account.
     *
     * @param float $amount
     * @throws \Exception
     */
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new \Exception('Le montant doit être supérieur à zéro.');
        }
        
        $this->solde += $amount;
        $this->save();

        // Enregistrer la transaction avec l'ID du compte destinataire
        Transaction::create([
            'montant' => $amount,
            'type' => 'depot',
            'id_compte_source' => null, // Pas de compte source pour un dépôt direct
            'id_compte_destinataire' => $this->id, // ID du client qui reçoit le dépôt
            'statut' => 'effectuée',
        ]);
    }

    /**
     * Withdraw amount from the client's account.
     *
     * @param float $amount
     * @throws \Exception
     */
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new \Exception('Le montant doit être supérieur à zéro.');
        }
        
        // Calcul des frais (1% du montant)
        $frais = $amount * 0.01;

        if ($this->solde >= ($amount + $frais)) {
            $this->solde -= ($amount + $frais);
            $this->save();

            // Enregistrer la transaction avec l'ID du compte source
            Transaction::create([
                'montant' => $amount,
                'type' => 'retrait',
                'id_compte_source' => $this->id, // ID du client qui effectue le retrait
                'id_compte_destinataire' => null, // Pas de compte destinataire pour un retrait
                'frais' => $frais, // Ajouter les frais
                'statut' => 'effectuée',
            ]);

            // Ajouter les frais au compte du distributeur
            $this->ajouterFraisAuCompteDistributeur($frais);
        } else {
            throw new \Exception('Solde insuffisant.');
        }
    }

    /**
     * Ajouter les frais au compte du distributeur.
     *
     * @param float $frais
     */
    protected function ajouterFraisAuCompteDistributeur(float $frais): void
    {
        // ID du distributeur, changez-le si nécessaire
        $id_distributeur = 1; // Remplacez par votre logique
        $distributeur = Client::find($id_distributeur);
        
        // Mise à jour du solde du distributeur
        if ($distributeur) {
            $distributeur->solde += $frais;
            $distributeur->save();
        }
    }
}
