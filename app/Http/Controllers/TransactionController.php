<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Distributeurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction; // Assurez-vous d'importer le modèle Transaction

class TransactionController extends Controller
{

  
    // Crédits d'un Distributeur par l'agent
    public function transferFromAgentToDistributeur(Request $request)
    {

    
        // Règles de validation
       $request->validate([
            'montant' => 'required|numeric|min:500', // Montant requis, numérique, et supérieur à 500
            'distributeur_id' => 'required|exists:users,id', // Distributeur existant
        ]);

        $agent = Auth::user();
        $distributeur = Distributeurs::where('id_user', $request->distributeur_id)->first();
        var_dump($distributeur);
        // Logique de transfert
        $distributeur->solde += $request->montant;
        $distributeur->save();

        // Enregistrer la transaction
        Transaction::create([
            'id_compte_source' => $agent->id,
            'id_compte_destinataire' => $distributeur->id,
            'id_distributeur' => $agent->id,
            'montant' => $request->montant,
            'type' => 'envoi',
            'frais' => 0, // Ajouter une logique pour les frais si nécessaire
        ]);

        return redirect()->back()->with('success', 'Transfert effectué avec succès.');
    }

    // Dépôt du distributeur au client
    public function transferFromDistributeurToClient(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:500',
            'telephone' => 'required|exists:users,telephone',
        ]);


        //$distributeur = Distributeurs::where('te', 1)->first();
        $user0 = Auth::user();
        $distributeur = Distributeurs::where('id_user', $user0->id)->first();

        $user = User::where('telephone', $request->telephone)-> first();
        $client = Client::where('id_user', $user->id)->first();

        $frais = $request->montant * 0.01; // Calcul des frais

        if ($distributeur->solde < $request->montant) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        // Logique de transfert
        $distributeur->solde -= $request->montant;
        $distributeur->solde += $frais;
        $client->solde += $request->montant;
        $distributeur->save();
        $client->save();

        Transaction::create([
            'id_compte_source' => $distributeur->id,
            'id_compte_destinataire' => $client->id,
            'id_distributeur' => $distributeur->id,
            'montant' => $request->montant,
            'type' => 'envoi',
            'frais' => $frais,
        ]);

        return redirect()->back()->with('success', 'Transfert effectué avec succès.');
    }

    // Retrait du Client au distributeur 
    public function withdrawForDistributeur(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:500',
            'telephone' => 'required|exists:users,telephone',
        ]);

        //$distributeur = Distributeurs::where('id', 1)->first();
        $user0 = Auth::user();
        $distributeur = Distributeurs::where('id_user', $user0->id)->first();

        $user1 = User::where('telephone', $request->telephone)-> first(); 
        $client = Client::where('id_user', $user1->id)->first();
        
        // Calcul des frais (1 % du montant)
        $frais = $request->montant * 0.01;
    
        // Vérification du solde du client après application des frais
        if ($client->solde < $request->montant + $frais) {
            return redirect()->back()->with('error', 'Solde insuffisant après application des frais.');
        }
    
        // Logique de transfert
        $client->solde -= $request->montant ; // Déduit le montant du client
        $distributeur->solde += $request->montant + $frais; // Ajoute le montant au distributeur
        $client->save();
        $distributeur->save();
    
        // Enregistrer la transaction avec les frais
        Transaction::create([
            'id_compte_source' => $client->id,
            'id_compte_destinataire' => $distributeur->id,
            'id_distributeur' => $distributeur->id,
            'montant' => $request->montant,
            'type' => 'retrait',
            'frais' => $frais,
        ]);
    
        return redirect('distributeur/dashboard')->with('success', 'Retrait effectué avec succès.');
    }

    // Envoi Client → Client
    public function sendMoneyToClient(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:500',
            'telephone' => 'required|exists:users,telephone', // Assurez-vous que la table est correcte
        ]);

        $userFrom = Auth::user();
        $clientFrom = Client::where('id_user', $userFrom->id)->first();

        $user = User::where('telephone',$request->telephone)->first();
        $clientTo = Client::where('id_user', $user->id)->first();

        // Calcul des frais (2 % du montant)
        $frais = $request->montant * 0.02;

        if ($clientFrom->solde < $request->montant + $frais) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        $clientFrom->solde -= $request->montant + $frais;
        $clientTo->solde += $request->montant;
        $clientFrom->save();
        $clientTo->save();

        Transaction::create([
            'id_compte_source' => $clientFrom->id,
            'id_compte_destinataire' => $clientTo->id,
            'id_distributeur' => null, // Pas de distributeur impliqué ici
            'montant' => $request->montant,
            'type' => 'envoi',
            'frais' => $frais,
        ]);

        return redirect()->back()->with('success', 'Transfert effectué avec succès.');
    }
}