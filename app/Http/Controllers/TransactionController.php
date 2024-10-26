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
            'client_id' => 'required|exists:users,id',
        ]);


        $distributeur = Distributeurs::where('id', 1)->first();
        //$distributeur = Auth::user();
        $client = Client::where('id_user', $request->client_id)-> first();
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
            'client_id' => 'required|exists:users,id',
        ]);

        $distributeur = Distributeurs::where('id', 1)->first();
        //$distributeur = Auth::user();
        $client = Client::where('id_user', $request->client_id)-> first(); 
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
    
        return redirect()->back()->with('success', 'Retrait effectué avec succès.');
    }

    // Envoi Client → Client
    public function sendMoneyToClient(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:500',
            'client_id' => 'required|exists:users,id', // Assurez-vous que la table est correcte
        ]);

        $clientFrom = Auth::user();
        $clientTo = User::find($request->client_id);

        // Calcul des frais (2 % du montant)
        $frais = $request->montant * 0.02;

        if ($clientFrom->compte->solde < $request->montant + $frais) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        $clientFrom->compte->solde -= $request->montant + $frais;
        $clientTo->compte->solde += $request->montant;
        $clientFrom->compte->save();
        $clientTo->compte->save();

        Transaction::create([
            'id_compte_source' => $clientFrom->compte->id,
            'id_compte_destinataire' => $clientTo->compte->id,
            'id_distributeur' => null, // Pas de distributeur impliqué ici
            'montant' => $request->montant,
            'type' => 'envoi',
            'frais' => $frais,
        ]);

        return redirect()->back()->with('success', 'Transfert effectué avec succès.');
    }
}