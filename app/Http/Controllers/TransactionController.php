<?php
namespace App\Http\Controllers;
use App\Models\Distributeur; 

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function depot(Request $request)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:1'
        ]);

        $client = Client::where('numero_compte', $request->numero_compte)->first();
        
        if (!$client || $client->statut == 'bloqué') {
            return redirect()->back()->with('error', 'Compte non valide ou bloqué.');
        }

        $client->solde += $request->montant;
        $client->save();

        Transaction::create([
            'id_compte_source' => $client->id,
            'montant' => $request->montant,
            'type' => 'depot',
            'frais' => $request->montant * 0.01
        ]);

        return redirect()->back()->with('message', 'Dépôt effectué avec succès.');
    }

    public function retrait(Request $request)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:1'
        ]);

        $client = Client::where('numero_compte', $request->numero_compte)->first();
        
        if (!$client || $client->statut == 'bloqué') {
            return redirect()->back()->with('error', 'Compte non valide ou bloqué.');
        }

        if ($client->solde < $request->montant) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        $client->solde -= $request->montant;
        $client->save();

        Transaction::create([
            'id_compte_source' => $client->id,
            'montant' => $request->montant,
            'type' => 'retrait',
            'frais' => $request->montant * 0.01
        ]);

        return redirect()->back()->with('message', 'Retrait effectué avec succès.');
    }

  
   // App\Http\Controllers\TransactionController.php


    // Afficher les transactions
    public function index()
    {
        $distributeurId = 1; // Remplacez par l'ID réel du distributeur.
    
        // Récupérer toutes les transactions liées à ce distributeur
        $transactions = Transaction::with(['clientSource.user', 'clientDestinataire.user'])
            ->where('id_compte_source', $distributeurId)
            ->orWhere('id_compte_destinataire', $distributeurId)
            ->get();
    
        return view('historique', compact('transactions'));
    }
    
    

    // Annuler une transaction
    
   
    public function cancel(Transaction $transaction, $distributeurId)
    {
        // Vérifiez si le distributeur existe
        $distributeur = Distributeur::find($distributeurId);
    
        if (!$distributeur) {
            return redirect()->route('historiques.index')->with('error', 'Distributeur introuvable.');
        }
    
        // Calculer le bonus à retirer (1% du montant de la transaction)
        $bonus = $transaction->montant * 0.01;
    
        // Vérifier si le distributeur a suffisamment de solde pour l'annulation du bonus
        if ($distributeur->solde < $bonus) {
            return redirect()->route('historiques.index')->with('error', 'Solde insuffisant pour annuler la transaction.');
        }
    
        // Débiter le bonus du solde du distributeur
        $distributeur->solde -= $bonus;
        $distributeur->save();
    
        // Supprimer la transaction
        $transaction->delete();
    
        return redirect()->route('historiques.index')->with('success', 'Transaction annulée avec succès.');
    }
    
}