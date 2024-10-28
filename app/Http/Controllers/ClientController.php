<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    // ID du distributeur, changez-le si nécessaire
    private const DISTRIBUTEUR_ID = 1;

    public function index()
    {
        // Récupère tous les clients
        $clients = Client::with('user')->get();

        // Renvoie la vue avec les clients
        return view('distributeurclients', compact('clients'));
    }

   
}    