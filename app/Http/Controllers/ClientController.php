<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // ID du distributeur, changez-le si nécessaire
    private const DISTRIBUTEUR_ID = 1;

    public function index()
    {
        // Récupère tous les clients
        $clients = Client::with('user')->get();

        // Renvoie la vue avec les clients
        return view('distributeurclients', compact('clients'));
    }

    public function credit(Request $request, $id)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
        ]);

        $client = Client::findOrFail($id);
        $client->solde += $request->montant;
        $client->save();

        // Enregistrer la transaction de dépôt
        Transaction::create([
            'montant' => $request->montant,
            'type' => 'depot',
            'id_compte_source' => self::DISTRIBUTEUR_ID, // Distributeur comme source
            'id_compte_destinataire' => $client->id,      // Le client qui reçoit le dépôt
        ]);

        return redirect()->route('clients.index')->with('success', 'Montant crédité avec succès.');
    }

    public function retirer(Request $request, $id)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
        ]);

        $client = Client::findOrFail($id);

        if ($client->solde >= $request->montant) {
            // Calcul des frais (1% du montant)
            $frais = $request->montant * 0.01;

            // Mettre à jour le solde du client
            $client->solde -= ($request->montant + $frais);
            $client->save();

            // Enregistrer la transaction de retrait
            Transaction::create([
                'montant' => $request->montant,
                'type' => 'retrait',
                'id_compte_source' => $client->id, // Le client qui effectue le retrait
                'id_compte_destinataire' => null,   // Pas de destinataire pour le retrait
                'frais' => $frais,                  // Ajouter les frais
            ]);

            // Ajouter les frais au compte distributeur
            $this->ajouterFraisAuCompteDistributeur($frais);

            return redirect()->route('clients.index')->with('success', 'Montant retiré avec succès.');
        }

        return redirect()->route('clients.index')->with('error', 'Solde insuffisant.');
    }

    public function annuler(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        // Vérifier si la transaction est un retrait ou un dépôt avant d'annuler
        if ($transaction->type == 'retrait') {
            // Débiter les frais du compte distributeur
            $this->debiterFraisDuCompteDistributeur($transaction->frais);
        }

        // Supprimez la transaction
        $transaction->delete();

        return redirect()->route('clients.index')->with('success', 'Transaction annulée avec succès.');
    }

    protected function ajouterFraisAuCompteDistributeur($frais)
    {
        $distributeur = Client::find(self::DISTRIBUTEUR_ID);
        if ($distributeur) {
            $distributeur->solde += $frais;
            $distributeur->save();
        }
    }

    protected function debiterFraisDuCompteDistributeur($frais)
    {
        $distributeur = Client::find(self::DISTRIBUTEUR_ID);

        if ($distributeur && $distributeur->solde >= $frais) {
            $distributeur->solde -= $frais;
            $distributeur->save();
        } else {
            // Gestion d'erreur si le solde est insuffisant
            // Vous pouvez retourner un message d'erreur ou gérer cela autrement
        }
    }


    // ClientController.php

    public function transfert(Request $request)
    {
        $request->validate([
            'id_compte_source' => 'required|exists:clients,id', // Vérifie que le compte source existe
            'id_compte_destinataire' => 'required|exists:clients,id', // Vérifie que le compte destinataire existe
            'montant' => 'required|numeric|min:1',
            'type' => 'required|in:transfert',
        ]);
    
        // Récupération des comptes
        $compteSource = Client::findOrFail($request->id_compte_source);
        $compteDestinataire = Client::findOrFail($request->id_compte_destinataire);
    
        if ($compteSource->solde < $request->montant) {
            return redirect()->back()->with('error', 'Solde insuffisant sur le compte source.');
        }
    
        // Début de la transaction
        \DB::beginTransaction();
    
        try {
            // Débiter le compte source
            $compteSource->solde -= $request->montant;
            $compteSource->save();
    
            // Créditer le compte destinataire
            $compteDestinataire->solde += $request->montant;
            $compteDestinataire->save();
    
            // Enregistrer la transaction
            Transaction::create([
                'montant' => $request->montant,
                'type' => $request->type,
                'id_compte_source' => $compteSource->id,
                'id_compte_destinataire' => $compteDestinataire->id,
            ]);
    
            // Confirmer la transaction
            \DB::commit();
    
            return redirect()->route('clients.index')->with('success', 'Transfert effectué avec succès.');
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            \DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors du transfert. Veuillez réessayer.');
        }
    }
    
    public function showTransfertForm()
{
    // Récupérer tous les clients de la base de données
    $clients = Client::all(); // Assurez-vous que cette ligne est correcte et que vous avez des clients

    return view('transfert', compact('clients')); // Passez les clients à la vue
}
public function storeTransfert(Request $request)
{
    // Valider les données du formulaire
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'montant' => 'required|numeric|min:0',
    ]);

    // Logique pour effectuer le transfert
    $client = Client::find($request->client_id);
    // ... ajoutez votre logique pour mettre à jour le solde ou enregistrer la transaction

    return redirect()->route('transfert.form')->with('success', 'Transfert effectué avec succès!');
}


    

    
    
}    