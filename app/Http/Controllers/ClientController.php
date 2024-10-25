<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importation de la façade DB

class ClientController extends Controller
{
    public function index(Request $request) 
    {
        // Récupérer tous les enregistrements de la table clients
       // $userId = $request->user()->id; // Récupère l'ID de l'utilisateur connecté
       $userId = 1 ;

       $transactions = DB::table('transactions')
       ->join('clients as source', 'transactions.id_compte_source', '=', 'source.id')
       ->join('clients as destination', 'transactions.id_compte_destinataire', '=', 'destination.id')
       ->join('users as source_user', 'source.id_user', '=', 'source_user.id') // Jointure avec la table users pour le compte source
       ->join('users as destination_user', 'destination.id_user', '=', 'destination_user.id') // Jointure pour le compte destinataire
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
           'source_user.prenom as prenom_source', // Sélection du prénom de l'utilisateur source
           'source_user.nom as nom_source',       // Sélection du nom de l'utilisateur source
           'source_user.telephone as telephone', // Sélection du telephone
           'destination_user.prenom as prenom_destination', // Sélection du prénom de l'utilisateur destinataire
           'destination_user.nom as nom_destination'        // Sélection du nom de l'utilisateur destinataire
       )
       ->get();
         // Passer les données à la vue
        return view('client', ['transactions' => $transactions]);
    }

    public function getTransaction($id){
        
    }
}

 




























