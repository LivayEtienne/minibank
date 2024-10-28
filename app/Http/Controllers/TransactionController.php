<?php
namespace App\Http\Controllers;
use App\Models\Client; 

use App\Models\Transaction;
use App\Models\Distributeur;
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


   public function index($distributeurId)
   {
       // Récupérer toutes les transactions liées à ce distributeur
       $transactions = Transaction::with(['clientSource.user', 'clientDestinataire.user'])
           ->where('id_compte_source', $distributeurId)
           ->orWhere('id_compte_destinataire', $distributeurId)
           ->paginate(10); // Ajout de la pagination
   
       // Récupérer les détails du distributeur
       $distributeur = Distributeur::findOrFail($distributeurId); // Utiliser findOrFail pour simplifier
   
       // Passer la variable à la vue
       return view('historique', compact('transactions', 'distributeur', 'distributeurId'));
   }
   
   
   // Annuler une transaction
   public function cancel(Request $request, $transactionId, $distributeurId)
   {
       // Vérifiez si le distributeur existe
       $distributeur = Distributeur::findOrFail($distributeurId); // Utiliser findOrFail
   
       // Trouver la transaction à annuler
       $transaction = Transaction::findOrFail($transactionId); // Assurez-vous que la transaction existe

       
   
       // Calculer le bonus à retirer (1% du montant de la transaction)
       $bonus = $transaction->montant * 0.01;
   
       // Vérifier si le distributeur a suffisamment de solde
       if ($distributeur->solde < $bonus) {
           return redirect()->route('historiques.index', $distributeurId)->with('error', 'Solde insuffisant pour annuler la transaction.');
       }
   
       // Débiter le bonus du solde du distributeur
       $distributeur->solde -= $bonus;
       $distributeur->save();
   
       // Supprimer la transaction
       $transaction->delete(); // Considérez l'utilisation des soft deletes
   
       return redirect()->route('historiques.index', $distributeurId)->with('success', 'Transaction annulée avec succès.');
   }
}   