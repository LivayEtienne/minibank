<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\Distributeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributeurController extends Controller
{
    public function index()
    {
        // Récupérer tous les clients pour les afficher
        $clients = Client::all();
        $distributeur = Distributeur::first();

        // Comptez le nombre de transactions
        $nombreTransactions = Transaction::count();

         // Renvoie la vue distributeur.blade.php avec les clients, le distributeur et le nombre de transactions
    return view('distributeur', compact('clients', 'distributeur', 'nombreTransactions'));
    }

    public function show($id)
    {
        // Trouver un distributeur par son ID
        $distributeur = Distributeur::findOrFail($id);

        // Comptez le nombre de transactions
        $nombreTransactions = Transaction::count();

        // Renvoie la vue distributeur avec le distributeur et le nombre de transactions
        return view('distributeur', compact('distributeur', 'nombreTransactions'));
    }

    // Fonction pour afficher le solde
    public function dashboard()
    {
        // Récupérez le solde depuis votre base de données ou autre source
        $distributeur = Distributeur::first(); // Récupération du premier distributeur pour obtenir le solde
        $solde = $distributeur ? $distributeur->solde : 0; // Vérification si le distributeur existe

        // Comptez le nombre de transactions
        $nombreTransactions = Transaction::count();

        // Passez le solde et le nombre de transactions à la vue
        return view('distributeur', [
            'solde' => $solde,
            'nombreTransactions' => $nombreTransactions,
            'distributeur' => $distributeur // Ajout du distributeur pour d'autres besoins dans la vue
        ]);
    }

    public function showClients()
    {
        // Récupère tous les clients avec leurs utilisateurs associés
        $clients = Client::with('user')->get();

        // Comptez le nombre de transactions
        $nombreTransactions = Transaction::count();

        // Renvoie la vue avec les clients et le nombre de transactions
        return view('distributeur', compact('clients', 'nombreTransactions'));
    }

    public function showHistory(Request $request)
    {
        // Récupérer toutes les transactions
        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        // Récupérer le solde du distributeur
        $distributeur = Distributeur::find(1); // Remplacez par l'ID approprié
        $solde = $distributeur ? $distributeur->solde : 0;

        // Renvoie la vue avec l'historique des transactions et le solde
        return view('historique', compact('transactions', 'solde'));
    }
}
