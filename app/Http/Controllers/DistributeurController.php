<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; // Assurez-vous d'importer votre modèle Client
use App\Models\Transaction; // Assurez-vous d'importer votre modèle Transaction
use App\Models\User; // Ajoutez cette ligne si vous souhaitez interagir avec le modèle User
use Illuminate\Support\Facades\Auth;

class DistributeurController extends Controller
{
    public function index()
    {
        // Récupérer les clients si nécessaire
        $clients = Client::all(); // Récupérez tous les clients pour les afficher

        // Renvoie la vue distributeur.blade.php avec les clients
        return view('distributeur', compact('clients'));
    }

    public function showClients()
{
    // Récupère tous les clients avec leurs utilisateurs associés
    $clients = Client::with('user')->get();

    // Renvoie la vue avec les clients
    return view('distributeur');
}

}
