<?php


namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\transaction;

class agentController extends Controller
{
    public function index(Request $request) 
    {
        // Simuler un ID utilisateur pour cette démonstration, remplace avec l'ID de l'utilisateur authentifié
        $userId = 1; 

        // Récupérer les transactions liées à cet utilisateur
        $transactions = DB::table('transactions')
           ->join('clients as source', 'transactions.id_compte_source', '=', 'source.id')
           ->join('clients as destination', 'transactions.id_compte_destinataire', '=', 'destination.id')
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
               'source_user.photo as photo_source', // pour la photo
               
               'destination_user.prenom as prenom_destination', 
               'destination_user.nom as nom_destination',
               'destination_user.photo as photo_destination'
           )
           ->get();

        // Passer les données à la vue transactions_agent
        return view('transactions_agent', ['transactions' => $transactions]);
    }

    //Création de compte d'utilisateur
    public function create()
    {
        // Récupérer les données de transactions par mois
        $transactionsParMois = Transaction::selectRaw('MONTH(created_at) as mois, SUM(montant) as total_montant')
            ->groupBy('mois')
            ->get()
            ->pluck('total_montant', 'mois')
            ->toArray();

        // Formater les données pour Chart.js
        $moisLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $montantData = array_fill(0, 12, 0); // Initialiser un tableau avec 12 zéros

        foreach ($transactionsParMois as $mois => $montant) {
            $montantData[$mois - 1] = $montant;
        }

        return view('index', compact('moisLabels', 'montantData'));
    }


    public function getSolde() {
//-
        // Logique pour recupérer le solde//-
        $agent = Auth::user()->id;//-
        $agent = Auth::id(); // Use Auth::id() instead of Auth::user()->id//+
        $solde = Agent::where('id_user', $agent)->first()->solde;
        return $solde;
    }

    public function listTransaction() 
    {
        // Simuler un ID utilisateur pour cette démonstration, remplace avec l'ID de l'utilisateur authentifié
        $userId = 1; 

        // Récupérer les transactions liées à cet utilisateur
        $transactions = DB::table('transactions')
           ->join('clients as source', 'transactions.id_compte_source', '=', 'source.id')
           ->join('clients as destination', 'transactions.id_compte_destinataire', '=', 'destination.id')
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
               'source_user.photo as photo_source', // pour la photo
               
               'destination_user.prenom as prenom_destination', 
               'destination_user.nom as nom_destination',
               'destination_user.photo as photo_destination'
           )
           ->get();

        // Passer les données à la vue transactions_agent
        return view('transactions_agent', ['transactions' => $transactions]);
    }


}

