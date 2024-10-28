<?php

namespace App\Http\Controllers;


use App\Models\Distributeurs;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class distributeurController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $distributeur = Distributeurs::where('id_user', $user->id)->first();
        $solde = $distributeur->solde;

        // Récupérer toutes les transactions du client
        $transactions = Transaction::where('id_compte_source', $user->id)
            ->orWhere('id_compte_destinataire', $user->id)
            ->orderBy('created_at', 'desc') // Trier par date décroissante
            ->paginate(10);
        
        return view('distributeur', compact('transactions', 'solde', 'user'));
    }

    public function getSolde() {

        // Logique pour recupérer le solde
        $distributeur = Auth::user()->id;
        $solde = Distributeurs::where('id_user', $distributeur)->first()->solde;
        return $solde;
    }

}
