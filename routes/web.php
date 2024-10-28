<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\distributeurController;



Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\agentController;


Route::get('/', function () {
    return view('welcome');

/*Route::get('agent/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('agent.dashboard');*/


// Route pour afficher le dashboard du client

//Route::get('/client', [ClientController::class, 'index']);


// Route pour afficher le dashboard du distributeur

/*Route::get('distributeur', function () {
    return view('distributeur');
});*/


//Route pour afficher la liste des transactions de l agent
})->middleware(['auth', 'verified'])->name('agent.dashboard');

// Route pour afficher le dashboard du client

Route::get('/client', [ClientController::class, 'index']);


// Route pour afficher le dashboard du distributeur

/*Route::get('distributeur', function () {
    return view('distributeur');
})->name('distributeur.dashboard');*/


//Route pour afficher la liste des transactions de l agent

Route::get('/transactions_agent', [agentController::class, 'index']);

Route::get('/index', [DashboardController::class, 'index'])->name('dashboard');


// Route pour afficher le formulaire de connexion (GET)
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');

// Route pour traiter la connexion (POST)
Route::post('/connexion', [AuthController::class, 'login'])->name('connexion');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('auth.register');

// Route pour soumettre le formulaire d'inscription
Route::post('/register', [RegisteredUserController::class, 'store'])->name('auth.register.store');

Route::get('/index', [StatistiqueController::class, 'index'])->name('dashboard');

Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/list_client', [ClientController::class, 'index'])->name('list_client');

Route::get('/edit_client/{id}', [ClientController::class, 'edit'])->name('edit_client');

Route::get('/clients/archived', [ClientController::class, 'showArchived'])->name('clients.archived');
Route::post('/clients/restore/{id}', [ClientController::class, 'restore'])->name('clients.restore');
Route::post('/clients/archive/{id}', [ClientController::class, 'archive'])->name('clients.archive');
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');




// Autres routes...

// Route pour afficher le formulaire d'édition d'un client
Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');

// Route pour mettre à jour les informations d'un client
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');



Route::get('/dashboard', function () {
    return view('index');
})->name('dashboard');

// routes/web.php
Route::post('/clients/block/{id}',function(){
    return response()->json(['success' => 'Client bloqué avec succès.']);
}); //[ClientController::class, 'block'])->name('clients.block');


// Route pour afficher la page de connexion
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/creer_compte', function () {
    return view('auth.register');
})->name('creer_compte');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //ROUTE POUR LE DISTRIBUTEUR
    Route::get('/distributeur/dashboard', [DistributeurController::class, 'index'])->name('distributeur.dashboard');

    //ROUTES POUR LE CLIENT 
    //ROUTES POUR LE CLIENT 
    Route::get('client/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});

//Les views pour l'interface des transactons du distributeur
Route::get('/distributeur/depot', function () {
    return view('transaction/depot');
})->name('transactions.depot');

Route::get('/distributeur/retrait', function () {
    $solde = app(distributeurController::class)->getSolde(); 

    return view('transaction/retrait');
})->name('transactions.retrait');

Route::get('/client/transfer', function () {
    $qrCode = app(ClientController::class)->generate();
    $solde = app(ClientController::class)->getSolde(); 
    
    return view('transaction/transfer',[ 
    'qrCode' => 'data:image/png;base64,'. $qrCode,
    'solde' => $solde // Par défaut, 0 si pas de client trouvé
    ]);
})->name('transactions.transfer');

    



// ROUTE POUR LES TRANSACTIONS

// Route pour le dépôt
Route::post('/distributeur/depot', [TransactionController::class, 'transferFromDistributeurToClient'])->name('transaction.depot');

// Route pour le retrait
Route::post('/distributeur/retrait', [TransactionController::class, 'withdrawForDistributeur'])->name('transaction.retrait');

// Route pour le transfer
Route::post('/client/transfer', [TransactionController::class, 'sendMoneyToClient'])->name('transaction.transfer');


require __DIR__.'/auth.php';

/*Route::get('/agent/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/client/dashboard', [ClientController::class, 'index'])->name('client.dashboard')->middleware('auth');
Route::get('/distributeur/dashboard', [DistributeurController::class, 'index'])->name('distributeur.dashboard')->middleware('auth');*/

/*Route::get('/agent/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/client/dashboard', [ClientController::class, 'index'])->name('client.dashboard')->middleware('auth');
Route::get('/distributeur/dashboard', [DistributeurController::class, 'index'])->name('distributeur.dashboard')->middleware('auth');*/