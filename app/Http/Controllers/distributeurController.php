<?php

namespace App\Http\Controllers;


use App\Models\Distributeurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;//+

class distributeurController extends Controller
{
    //
    public function index() 
    {
        $userId = 2; // Remplacez par $request->user()->id si vous utilisez l'authentification

        // Récupérer le solde du distributeur
        $distributeur = Distributeurs::where('id_user', $userId)->first(['solde']);

        // Récupérer les transactions pour le distributeur
        $transactions = DB::table('transactions')
    ->join('distributeurs as source', 'transactions.id_compte_source', '=', 'source.id')
    ->join('distributeurs as destination', 'transactions.id_compte_destinataire', '=', 'destination.id')
    ->join('users as source_user', 'source.id_user', '=', 'source_user.id')
    ->join('users as destination_user', 'destination.id_user', '=', 'destination_user.id')
    ->where('source.id_user', $userId)
    ->orWhere('destination.id_user', $userId)
    ->select(
        'transactions.id',
        'transactions.id_compte_source',
        'transactions.id_compte_destinataire',
        'transactions.id_distributeur',
        'transactions.montant',
        'transactions.type',
        'transactions.date',
        'transactions.frais',
        'transactions.created_at',
        'transactions.updated_at',
        'source_user.prenom as prenom_source',
        'source_user.nom as nom_source',
        'source_user.telephone as telephone',
        'destination_user.prenom as prenom_destination',
        'destination_user.nom as nom_destination'
    )
    ->paginate(4); // Renvoie une collection vide si aucune transaction

       // Vérifiez si `$transactions` est bien une collection
       if (is_null($transactions)) {
        $transactions = collect(); // Crée une collection vide si aucune transaction trouvée
    }
    //dd($transactions);

       

        // Passer les données à la vue `distributeur`
        return view('distributeur', [
            'transactions' => $transactions,
           'solde' => $distributeur->solde,
        ]);
    }


    public function getSolde() {

        // Logique pour recupérer le solde
        $distributeur = Auth::user()->id;
        $solde = Distributeurs::where('id_user', $distributeur)->first()->solde;
        return $solde;
    }

}
