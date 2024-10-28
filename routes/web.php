<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\agentController;
use App\Http\Controllers\distributeurController;
use App\Http\Controllers\ClientController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('agent/dashboard', function () {
    return view('dashboard');
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

// Route pour afficher la page de connexion
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('login');


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