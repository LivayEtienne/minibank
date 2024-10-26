<?php
namespace App\Http\Controllers;

use App\Models\Client; // Assurez-vous d'importer le bon modèle
use App\Models\ClientModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\UserController;


class ClientController extends Controller
{
    public function index(Request $request) 
    {
        $userId = 1; // Remplacez par $request->user()->id si vous utilisez l'authentification

        // Récupérer le solde du client
        $client = ClientModel::where('id_user', $userId)->first(['solde']);

        // Récupérer les transactions
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
                'destination_user.prenom as prenom_destination',
                'destination_user.nom as nom_destination'
            )
            ->get();

        //recuperer le qrcode du client
        $base64QrCode = $this->generate($userId);
        
        

        // Passer les données à la vue
        return view('client', [
            'transactions' => $transactions,
            'qrCode' => 'data:image/png;base64,' . $base64QrCode,
            'solde' => $client ? $client->solde : 0 // Par défaut, 0 si pas de client trouvé
        ]);
    }

    public function getTransaction($id) {
        // Logique pour récupér
        
    }

    public function generate($id)
    {
        // Récupérer les données du client par ID
        $client = UserController::show($id);

        // Créer une chaîne avec les données du client
        $data = "Prenom: {$client->prenom}\nNom: {$client->nom}\nTéléphone: {$client->telephone}";

        // Générer le QR Code au format PNG
        $qrCode = QrCode::format('png')->size(300)->generate($data);

        // Convertir l'image en base64
        $base64QrCode = base64_encode($qrCode);

        return $base64QrCode;
      
    }

}

