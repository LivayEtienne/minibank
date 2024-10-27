<?php
// TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Créer une nouvelle transaction
    public function creerTransaction(Request $request)
    {
        $validatedData = $request->validate([
            'id_compte_source' => 'required|exists:clients,id',
            'id_compte_destinataire' => 'required|exists:clients,id',
            'id_distributeur' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:0',
            'type' => 'required|in:envoi,retrait,depot',
        ]);

        // Vérifier si l'utilisateur sélectionné comme agent a le rôle de 'agent'
        $agent = User::find($validatedData['id_distributeur']);
        if (!$agent || !$agent->isAgent()) {
            return response()->json(['message' => 'Utilisateur sélectionné n\'est pas un agent valide'], 400);
        }

        // Calcul des frais
        $frais = $this->calculerFrais($validatedData['type'], $validatedData['montant']);

        // Création de la transaction
        $transaction = Transaction::create([
            'id_compte_source' => $validatedData['id_compte_source'],
            'id_compte_destinataire' => $validatedData['id_compte_destinataire'],
            'id_distributeur' => $validatedData['id_distributeur'],
            'montant' => $validatedData['montant'],
            'type' => $validatedData['type'],
            'frais' => $frais,
            'date' => now(),
        ]);

        return response()->json(['message' => 'Transaction effectuée avec succès', 'transaction' => $transaction]);
    }

    // Méthode privée pour calculer les frais de transaction
    private function calculerFrais($type, $montant)
    {
        switch ($type) {
            case 'envoi':
                return $montant * 0.01; // 1% de frais pour les envois
            case 'retrait':
                return $montant * 0.005; // 0.5% de frais pour les retraits
            case 'depot':
            default:
                return 0; // Pas de frais pour les dépôts
        }
    }
}
