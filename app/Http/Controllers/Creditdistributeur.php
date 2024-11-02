<?php

namespace App\Http\Controllers;

use App\Models\Distributeurs; // Assurez-vous d'importer le modèle Distributeur
use App\Models\User;
use App\Models\transaction;      // Importer également le modèle User
use Illuminate\Http\Request;

class Creditdistributeur extends Controller
{
    public function showCreditForm()
{
    // Récupérer tous les utilisateurs de la table `users`
    $utilisateurs = User::all();

    // Retourner la vue avec tous les utilisateurs
    return view('credit_distributeur', compact('utilisateurs'));
}

public function crediter(Request $request)
{
    // Validation des données
    $request->validate([
        'id_user' => 'required|exists:users,id',
        'montant' => 'required|numeric|min:0',
    ]);

    // Recherche du distributeur par 'id_user' ou création s'il n'existe pas
    $distributeur = Distributeurs::firstOrCreate(
        ['id_user' => $request->id_user],
        ['numero_compte' => 'GENERE_AUTO', 'solde' => 0, 'bonus' => 0]
    );

    // Créditer le compte
    $distributeur->solde += $request->montant;
    $distributeur->save();

    return redirect()->back()->with('success', 'Compte crédité avec succès.');
}

 // Lister les transactions pour un distributeur


 public function listerTransactions($id_distributeur)
 {
     // Récupérer les transactions associées au distributeur
     $transactions = Transaction::where('id_distributeur', $id_distributeur)->get();

     return view('annulerTransaction', compact('transactions', 'id_distributeur'));
 }

 // Annuler une transaction spécifique
 public function annulerTransaction($id)
 {
     // Trouver la transaction à annuler
     $transaction = Transaction::find($id);

     if ($transaction) {
         // Suppression de la transaction ou toute autre logique d'annulation
         $transaction->delete(); // Suppression de la transaction

         return redirect()->back()->with('success', 'Transaction annulée avec succès.');
     }

     return redirect()->back()->with('error', 'Transaction non trouvée.');
 }
}

