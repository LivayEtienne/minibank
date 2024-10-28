<?php

// namespace App\Http\Controllers;

// use App\Models\Client;
// use App\Models\Distributeurs;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
// use App\Models\User;
// use App\Models\Transaction; // Assurez-vous d'importer le modèle Transaction

// class TransactionController extends Controller
// {
    // Crédits d'un Distributeur par l'agent
    // public function transferFromAgentToDistributeur(Request $request)
    // {


        // Règles de validation
    //    $request->validate([
    //         'montant' => 'required|numeric|min:500', // Montant requis, numérique, et supérieur à 500
    //         'distributeur_id' => 'required|exists:users,id', // Distributeur existant
    //     ]);

    //     $agent = Auth::user();
    //     $distributeur = Distributeurs::where('id_user', $request->distributeur_id)->first();
    //     var_dump($distributeur);
    //     // Logique de transfert
    //     $distributeur->solde += $request->montant;
    //     $distributeur->save();

    //     // Enregistrer la transaction
    //     Transaction::create([
    //         'id_compte_source' => $agent->id,
    //         'id_compte_destinataire' => $distributeur->id,
    //         'id_distributeur' => $agent->id,
    //         'montant' => $request->montant,
    //         'type' => 'envoi',
    //         'frais' => 0, // Ajouter une logique pour les frais si nécessaire
    //     ]);

    //     return redirect()->back()->with('success', 'Transfert effectué avec succès.');
    // }

    // Dépôt du distributeur au client
    // public function transferFromDistributeurToClient(Request $request)
    // {
    //     $request->validate([
    //         'montant' => 'required|numeric|min:500',
    //         'client_id' => 'required|exists:users,id',
    //     ]);


    //     $distributeur = Distributeurs::where('id', 1)->first();
    //     //$distributeur = Auth::user();
    //     $client = Client::where('id_user', $request->client_id)-> first();
    //     $frais = $request->montant * 0.01; // Calcul des frais

    //     if ($distributeur->solde < $request->montant) {
    //         return redirect()->back()->with('error', 'Solde insuffisant.');
    //     }

    //     // Logique de transfert
    //     $distributeur->solde -= $request->montant;
    //     $distributeur->solde += $frais;
    //     $client->solde += $request->montant;
    //     $distributeur->save();
    //     $client->save();

    //     Transaction::create([
    //         'id_compte_source' => $distributeur->id,
    //         'id_compte_destinataire' => $client->id,
    //         'id_distributeur' => $distributeur->id,
    //         'montant' => $request->montant,
    //         'type' => 'envoi',
    //         'frais' => $frais,
    //     ]);

    //     return redirect()->back()->with('success', 'Transfert effectué avec succès.');
    // }

    // // Retrait du Client au distributeur
    // public function withdrawForDistributeur(Request $request)
    // {
    //     $request->validate([
    //         'montant' => 'required|numeric|min:500',
    //         'client_id' => 'required|exists:users,id',
    //     ]);

    //     $distributeur = Distributeurs::where('id', 1)->first();
    //     //$distributeur = Auth::user();
    //     $client = Client::where('id_user', $request->client_id)-> first();
    //     // Calcul des frais (1 % du montant)
    //     $frais = $request->montant * 0.01;

    //     // Vérification du solde du client après application des frais
    //     if ($client->solde < $request->montant + $frais) {
    //         return redirect()->back()->with('error', 'Solde insuffisant après application des frais.');
    //     }

    //     // Logique de transfert
    //     $client->solde -= $request->montant ; // Déduit le montant du client
    //     $distributeur->solde += $request->montant + $frais; // Ajoute le montant au distributeur
    //     $client->save();
    //     $distributeur->save();

    //     // Enregistrer la transaction avec les frais
    //     Transaction::create([
    //         'id_compte_source' => $client->id,
    //         'id_compte_destinataire' => $distributeur->id,
    //         'id_distributeur' => $distributeur->id,
    //         'montant' => $request->montant,
    //         'type' => 'retrait',
    //         'frais' => $frais,
    //     ]);

    //     return redirect()->back()->with('success', 'Retrait effectué avec succès.');
    // }

//     // Envoi Client → Client
//     public function sendMoneyToClient(Request $request)
//     {
//         $request->validate([
//             'montant' => 'required|numeric|min:500',
//             'client_id' => 'required|exists:users,id', // Assurez-vous que la table est correcte
//         ]);

//         $clientFrom = Auth::user();
//         $clientTo = User::find($request->client_id);

//         // Calcul des frais (2 % du montant)
//         $frais = $request->montant * 0.02;

//         if ($clientFrom->compte->solde < $request->montant + $frais) {
//             return redirect()->back()->with('error', 'Solde insuffisant.');
//         }

//         $clientFrom->compte->solde -= $request->montant + $frais;
//         $clientTo->compte->solde += $request->montant;
//         $clientFrom->compte->save();
//         $clientTo->compte->save();

//         Transaction::create([
//             'id_compte_source' => $clientFrom->compte->id,
//             'id_compte_destinataire' => $clientTo->compte->id,
//             'id_distributeur' => null, // Pas de distributeur impliqué ici
//             'montant' => $request->montant,
//             'type' => 'envoi',
//             'frais' => $frais,
//         ]);

//         return redirect()->back()->with('success', 'Transfert effectué avec succès.');
//     }
// }

namespace App\Http\Controllers;




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Compte;
use App\Models\Distributeur;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Supposons que vous récupérez l'utilisateur connecté de manière explicite.
        $userId = session('user_id'); // ou tout autre moyen pour récupérer l'ID de l'utilisateur connecté
        $user = User::find($userId); // Rechercher l'utilisateur par ID

        // Supposons que l'ID du distributeur est récupéré de la session ou d'une configuration
        $distributeurId = config('app.default_distributeur_id'); // Par exemple, depuis la configuration
        $distributeur = Distributeur::find($distributeurId);

        // Si l'utilisateur ou le distributeur n'est pas trouvé, redirigez vers la page de connexion ou une page d'erreur
        if (!$user || !$distributeur) {
            return redirect()->route('login'); // Rediriger si l'utilisateur ou le distributeur n'est pas trouvé
        }

        // Récupérer l'historique des transactions de l'utilisateur
        $transactions = $this->getTransactionsForUser($userId);

        return view('distributeur', compact('user', 'transactions', 'distributeur'));
    }

    // Méthode pour gérer l'effet d'une transaction
    public function effectuerTransaction(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'type' => 'required|in:depot,retrait,envoi',
            'id_compte_source' => 'required|exists:comptes,id',
            'id_compte_destinataire' => 'required_if:type,envoi|exists:comptes,id',
            'id_distributeur' => 'required|exists:distributeurs,id',
        ]);

        // Récupérer les comptes et le distributeur
        $compteSource = Compte::find($validated['id_compte_source']);
        $compteDestinataire = $validated['type'] === 'envoi' ? Compte::find($validated['id_compte_destinataire']) : null;
        $distributeur = Distributeur::find($validated['id_distributeur']);

        // Logique de gestion de la transaction (exemple simplifié)
        // Effectuer l'opération selon le type (dépôt, retrait, envoi)
        if ($validated['type'] === 'depot') {
            $compteSource->solde += $validated['montant'];
        } elseif ($validated['type'] === 'retrait') {
            if ($compteSource->solde >= $validated['montant']) {
                $compteSource->solde -= $validated['montant'];
            } else {
                return back()->withErrors(['montant' => 'Solde insuffisant pour le retrait.']);
            }
        } elseif ($validated['type'] === 'envoi') {
            if ($compteSource->solde >= $validated['montant']) {
                $compteSource->solde -= $validated['montant'];
                $compteDestinataire->solde += $validated['montant'];
                $compteDestinataire->save();
            } else {
                return back()->withErrors(['montant' => 'Solde insuffisant pour l\'envoi.']);
            }
        }

        // Enregistrer les modifications
        $compteSource->save();

        // Créer une transaction
        Transaction::create([
            'id_compte_source' => $compteSource->id,
            'id_compte_destinataire' => $compteDestinataire ? $compteDestinataire->id : null,
            'id_distributeur' => $distributeur->id,
            'montant' => $validated['montant'],
            'type' => $validated['type'],
            'date' => now(),
            'frais' => 0, // Remplacer par la logique de frais si nécessaire
        ]);

        // Rediriger avec succès
        return redirect()->route('distributeur')->with('success', 'Transaction effectuée avec succès.');
    }

    // Exemple de méthode pour récupérer les transactions de l'utilisateur
    private function getTransactionsForUser($userId)
    {
        return Transaction::where('id_compte_source', $userId)
            ->orWhere('id_compte_destinataire', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
