<?php

namespace App\Http\Controllers;

use App\Models\distributeurModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\UserController;

class distributeurController extends Controller
{
    public function index(Request $request) 
    {
        $userId = 2; // Remplacez par $request->user()->id si vous utilisez l'authentification

        // Récupérer le solde du distributeur
        $distributeur = distributeurModel::where('id_user', $userId)->first(['solde']);

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
    ->get() ?? collect(); // Renvoie une collection vide si aucune transaction

       // Vérifiez si `$transactions` est bien une collection
       if (is_null($transactions)) {
        $transactions = collect(); // Crée une collection vide si aucune transaction trouvée
    }
    //dd($transactions);

        // Récupérer le QR code pour le distributeur
        $base64QrCode = $this->generate($userId);

        // Passer les données à la vue `distributeur`
        return view('distributeur', [
            'transactions' => $transactions,
            'qrCode' => $base64QrCode,
           'solde' => $distributeur->solde,
        ]);
    }

    public function generate($id)
    {
        // Récupérer les données du distributeur par ID
        $distributeur = UserController::show($id);

        // Créer une chaîne avec les données du distributeur
        $data = "Prenom: {$distributeur->prenom}\nNom: {$distributeur->nom}\nTéléphone: {$distributeur->telephone}";

        // Générer le QR Code au format PNG
        $qrCode = QrCode::format('png')->size(300)->generate($data);

        // Convertir l'image en base64
        $base64QrCode = base64_encode($qrCode);

        return $base64QrCode;
    }
}
