<?php

namespace App\Http\Controllers;

use App\Models\Client; // Assurez-vous d'importer le bon modèle
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClientController extends Controller
{
    public function index() 
    {
        $userId = 1; // Remplacez par $request->user()->id si vous utilisez l'authentification

        // Récupérer le solde du client
        $user = Auth::user();
        $client = Client::where('id_user', $user->id)->first();
        $solde = $client->solde;
        // Récupérer toutes les transactions du client
        $transactions = Transaction::where('id_compte_source', $user->id)
            ->orWhere('id_compte_destinataire', $user->id)
            ->orderBy('created_at', 'desc') // Trier par date décroissante
            ->paginate(10);
    

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
        $base64QrCode = $this->generate();
        
        

        // Passer les données à la vue
        return view('client', [
            'transactions' => $transactions,
            'qrCode' => 'data:image/png;base64,' . $base64QrCode,
            'solde' => $solde // Par défaut, 0 si pas de client trouvé
        ]);
    }



    public function generate()
    {
        // Récupérer les données du client par ID
        $client = Auth::User();

        // Créer une chaîne avec les données du client
        $data = "Prenom: {$client->prenom}\nNom: {$client->nom}\nTéléphone: {$client->telephone}";

        // Générer le QR Code au format PNG
        $qrCode = QrCode::format('png')->size(300)->generate($data);

        // Convertir l'image en base64
        $base64QrCode = base64_encode($qrCode);

        return $base64QrCode;
      
    }

    public function getSolde() {

        // Logique pour recupérer le solde
        $client = Auth::user()->id;
        $solde = Client::where('id_user', $client)->first()->solde;
        return $solde;
    }

    public function showArchived()
    {
        // Récupérer les clients où 'archived' = true
        $archivedClients = User::where('archived', true)->paginate(5);

        // Retourner la vue avec les clients archivés
        return view('auth.list_archived_clients', compact('archivedClients'));
    }

    /**
     * Restaurer un client archivé.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $client = User::findOrFail($id);
        $client->archived = false; // Changer l'état de l'archivage
        $client->save();

        return redirect()->route('clients.archived')->with('success', 'Client restauré avec succès.');
    }

    /**
     * Archiver un client actif.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive($id)
    {
        $client = User::findOrFail($id);
        $client->archived = true; // Changer l'état de l'archivage
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Client archivé avec succès.');
    }

    /**
     * Affiche la liste des clients actifs.
     *
     * @return \Illuminate\View\View
     */
    public function listerClient(Request $request)
    {
        // Récupérer le filtre de rôle depuis la requête, par défaut à 'all'
        $roleFilter = $request->get('role', 'all');
       // dd($roleFilter);
        // Récupérer les utilisateurs filtrés avec pagination
        $activeClients = User::active() // Utilise la portée active
                             ->filterByRole($roleFilter) // Filtrage par rôle
                             ->paginate(5); // Ajout de la pagination

        // Retourner la vue avec les clients actifs
        return view('auth.list_client', compact('activeClients', 'roleFilter')); // Passez aussi le filtre à la vue
    }




    /**
     * Mettre à jour les informations d'un client.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */


    public function edit($id)
    {
        // Récupérer le client par son ID
        $client = User::findOrFail($id);

        // Retourner la vue d'édition avec le client
        return view('auth.edit_client', compact('client'));
    }

    /**
     * Mettre à jour les informations d'un client.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nom' => ['required', 'string', 'max:255', 'regex:/^[\S]+(\s[\S]+)*$/'],
        'prenom' => ['required', 'string', 'max:255', 'regex:/^[\S]+(\s[\S]+)*$/'],
        'telephone' => 'nullable|string|max:20',
        'date_naissance' => 'required|date',
        'adresse' => 'required|string|max:255',
        'cni' => 'required|string|max:20',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Récupérer le client par son ID
    $client = User::findOrFail($id);

    // Mise à jour des informations du client
    $client->nom = $request->nom;
    $client->prenom = $request->prenom;
    $client->telephone = $request->telephone;
    $client->date_naissance = $request->date_naissance;
    $client->adresse = $request->adresse;
    $client->cni = $request->cni;

    // Gestion de la photo s'il y en a une
    if ($request->hasFile('photo')) {
        // Supprime l'ancienne photo si elle existe
        if ($client->photo && file_exists(public_path($client->photo))) {
            unlink(public_path($client->photo));
        }

        // Stocke la nouvelle photo
        $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('photos'), $fileName);
        $client->photo = 'photos/' . $fileName;
    }

    // Enregistrer les modifications dans la base de données
    $client->save();

    // Rediriger vers l'index avec un message de succès
    return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
}



}