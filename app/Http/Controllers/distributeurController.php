<?php

namespace App\Http\Controllers;

use App\Models\Distributeurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

use Exception;

class DistributeurController extends Controller
{
    // Méthode pour afficher le tableau de bord du distributeur
    public function index()
{
    // Récupérer l'utilisateur authentifié
    $user = Auth::user();
    
    // Récupérer le distributeur associé à cet utilisateur
    $distributeur = Distributeurs::where('id_user', $user->id)->first();
    
    if (!$distributeur) {
        return redirect()->route('some.route')->withErrors('Distributeur non trouvé.'); // Remplacez 'some.route' par votre route de redirection
    }

    $solde = $distributeur->solde; // Pas besoin de vérifier ici, car nous avons déjà validé le distributeur

    // Récupérer toutes les transactions impliquant le distributeur
    $transactions = Transaction::where('id_compte_source', $distributeur->id)
        ->orWhere('id_compte_destinataire', $distributeur->id)
        ->orWhere('id_distributeur', $distributeur->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Vérification des transactions
    if ($transactions->isEmpty()) {
        // Vous pouvez gérer le cas où il n'y a pas de transactions
         return redirect()->back()->withErrors('Aucune transaction trouvée.');
    }

    // Retourner la vue avec les données nécessaires
    return view('distributeur', compact('transactions', 'solde', 'user'));
}



    public function getSolde() {

        // Logique pour recupérer le solde
        $distributeur = Auth::user()->id;
        $solde = Distributeurs::where('id_user', $distributeur)->first()->solde;
        return $solde;
    }
    
    




    public function annulerDepot($id)
    {
        DB::beginTransaction();
    
        try {
            // Récupérer la transaction par ID et vérifier qu'elle existe
            $transaction = Transaction::findOrFail($id);
    
            // Vérifier que la transaction est un dépôt et qu'elle est complétée
            if ($transaction->type !== 'depot' || $transaction->statut !== 'complété') {
                throw new Exception('Cette transaction ne peut pas être annulée.');
            }
    
            // Récupérer le client et le distributeur impliqués dans la transaction
            $client = Client::find($transaction->id_compte_destinataire);
            $distributeur = Distributeurs::find($transaction->id_compte_source);
    
            if (!$client || !$distributeur) {
                throw new Exception('Client ou distributeur non trouvé.');
            }
    
            // Calculer le montant net (montant déposé - frais) et le montant à restituer au distributeur
            $montantNet = $transaction->montant; // Montant total déposé
            $frais = $transaction->frais; // Frais perçus par le distributeur
    
            // Rétablir le solde du client à l'état avant la transaction
            $client->solde -= $montantNet; // Déduire le montant du client
            if ($client->solde < 0) {
                throw new Exception('Le solde du client est insuffisant pour annuler le dépôt.');
            }
    
            // Récupérer le montant du distributeur (ajouter le montant déposé)
            $distributeur->solde += $montantNet; // Récupérer le montant total déposé par le distributeur
            $distributeur->solde -= $frais; // Retirer les frais perçus
    
            // Sauvegarder les nouvelles valeurs de solde
            $client->save();
            $distributeur->save();
    
            // Mettre à jour le statut de la transaction
            $transaction->statut = 'annulé'; // Marquer comme annulée
            $transaction->save();
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Dépôt annulé avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Échec de l\'annulation du dépôt : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Échec de l\'annulation du dépôt : ' . $e->getMessage());
        }
    }
    
    
    public function annulerRetrait($id)
    {
        DB::beginTransaction();
    
        try {
            // Récupérer la transaction par ID et vérifier qu'elle existe
            $transaction = Transaction::findOrFail($id);
    
            // Vérifier que la transaction est un retrait et qu'elle est complétée
            if ($transaction->type !== 'retrait' || $transaction->statut !== 'complété') {
                throw new Exception('Cette transaction ne peut pas être annulée.');
            }
    
            // Récupérer le client et le distributeur impliqués dans la transaction
            $client = Client::find($transaction->id_compte_source);
            $distributeur = Distributeurs::find($transaction->id_compte_destinataire);
    
            if (!$client || !$distributeur) {
                throw new Exception('Client ou distributeur non trouvé.');
            }
    
            // Calculer le montant net et les frais
            $montantNet = $transaction->montant + $transaction->frais;
    
            // Vérifier que le distributeur a suffisamment de solde pour restituer le montant et les frais
            if ($distributeur->solde < $montantNet) {
                throw new Exception('Solde insuffisant du distributeur pour annuler le retrait.');
            }
    
            // Mise à jour des soldes
            $client->solde += $transaction->montant;  // Rembourse le montant retiré au client
            $distributeur->solde -= $montantNet;      // Déduit le montant total (montant + frais) du distributeur
    
            // Sauvegarder les nouvelles valeurs de solde
            $client->save();
            $distributeur->save();
    
            // Mettre à jour le statut de la transaction
            $transaction->statut = 'annulé'; // Marquer comme annulée
            $transaction->save();
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Retrait annulé avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Échec de l\'annulation du retrait : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Échec de l\'annulation du retrait : ' . $e->getMessage());
        }
    }
    
    

    // Méthode pour afficher l'historique des transactions
    public function afficherClients()
    {
        $clients = Client::all(); // Ou utilisez paginate() si nécessaire
        $distributeur = Distributeurs::where('id_user', Auth::id())->first();
    
        // Initialiser transactionCounts
        $transactionCounts = [
            'nombreTransactions' => 0,
            'nombreDepots' => 0,
            'nombreRetraits' => 0,
        ];
    
        // Vérifiez si le distributeur existe et récupérez le solde
        if ($distributeur) {
            // Comptez les transactions
            $transactionCounts['nombreTransactions'] = Transaction::where('id_distributeur', $distributeur->id_user)->count();
            $transactionCounts['nombreDepots'] = Transaction::where('type', 'depot')->where('id_distributeur', $distributeur->id_user)->count();
            $transactionCounts['nombreRetraits'] = Transaction::where('type', 'retrait')->where('id_distributeur', $distributeur->id_user)->count();
    
            // Récupérez le solde (solde)
            $solde = $distributeur->solde;
    
            // Récupérer toutes les transactions pour ce distributeur
            $transactions = Transaction::where('id_distributeur', $distributeur->id_user)
                ->orderBy('created_at', 'desc') // Trier par date
                ->paginate(3); // Pagination si nécessaire
        } else {
            \Log::warning('Distributor not found for user: ' . Auth::id());
            $solde = 0; // Solde par défaut si aucun distributeur trouvé
            $transactions = []; // Pas de transactions
        }
    
        // Passer les données à la vue
        return view('distributeur', compact('clients', 'distributeur', 'transactionCounts', 'solde', 'transactions'));
    }
    
    
    



            
   
    
    
    

    // Méthode pour afficher un distributeur spécifique
    public function show($id)
    {
        $distributeur = Distributeurs::findOrFail($id);
        return view('distributeur_show', compact('distributeur'));
    }
}
