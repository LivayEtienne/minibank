<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients archivés.
     *
     * @return \Illuminate\View\View
     */
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
    public function index(Request $request)
    {
        // Récupérer le filtre de rôle depuis la requête, par défaut à 'all'
        $roleFilter = $request->get('role', 'all');

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
        'email' => 'required|email|unique:users,email,' . $id,
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
    $client->email = $request->email;
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
