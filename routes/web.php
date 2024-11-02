<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\distributeurController;
use App\Http\Controllers\AgentController;



// Route d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login'])->name('connexion');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('auth.register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('auth.register.store');

// Routes pour le tableau de bord de l'agent
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('agent/dashboard', function () {
        return view('index');
    })->name('agent.dashboard');

    // Routes pour les transactions de l'agent
    Route::get('/transactions_agent', [AgentController::class, 'index'])->name('transactions.agent.index');

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour le distributeur
    Route::get('/distributeur/dashboard', [distributeurController::class, 'index'])->name('distributeur.dashboard');
    

    // Routes pour le client
    Route::get('/client/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});

// Routes pour les clients
Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'listerClient'])->name('clients.index');
    Route::get('/archived', [ClientController::class, 'showArchived'])->name('clients.archived');
    Route::post('/restore/{id}', [ClientController::class, 'restore'])->name('clients.restore');
    Route::post('/archive/{id}', [ClientController::class, 'archive'])->name('clients.archive');
    Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::post('/block/{id}', function () {
        return response()->json(['success' => 'Client bloqué avec succès.']);
    })->name('clients.block');
});

// Routes pour les transactions
Route::prefix('transactions')->group(function () {
    Route::post('/distributeur/depot', [TransactionController::class, 'transferFromDistributeurToClient'])->name('transaction.depot');
    Route::post('/distributeur/retrait', [TransactionController::class, 'withdrawForDistributeur'])->name('transaction.retrait');
    Route::post('/client/transfer', [TransactionController::class, 'sendMoneyToClient'])->name('transaction.transfer');
});

// Routes pour les pages de transaction du distributeur
Route::get('/distributeur/depot', function () {
    $solde = app(distributeurController::class)->getSolde(); 
    return view('transaction/depot', compact('solde'));
})->name('transactions.depot');

Route::get('/distributeur/retrait', function () {
    $solde = app(distributeurController::class)->getSolde(); 
    return view('transaction/retrait', compact('solde'));
})->name('transactions.retrait');

Route::get('/client/transfer', function () {
    $qrCode = app(ClientController::class)->generate();
    $solde = app(ClientController::class)->getSolde(); 

    return view('transaction/transfer', [ 
        'qrCode' => 'data:image/png;base64,'. $qrCode,
        'solde' => $solde,
    ]);
})->name('transactions.transfer');

// Routes d'authentification
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/creer_compte', function () {
    return view('auth.register');
})->name('creer_compte');

// Statistiques
Route::get('/index', [StatistiqueController::class, 'index'])->name('dashboard');


Route::get('/distributeur', [DistributeurController::class, 'getSolde'])->name('distributeur.index');



// Route for afficherClients
Route::get('/distributeur/dashboard', [DistributeurController::class, 'afficherClients'])->name('distributeur.dashboard');


// Route for annulerDepot
Route::delete('/transactions/{id}/annuler-depot', [DistributeurController::class, 'annulerDepot'])->name('transactions.annulerDepot');

// Route for annulerRetrait
Route::delete('/transactions/{id}/annuler-retrait', [DistributeurController::class, 'annulerRetrait'])->name('transactions.annulerRetrait');





// Route for afficherHistoriqueTransactions
Route::get('/distributeur/historique', [DistributeurController::class, 'afficherHistoriqueTransactions'])->name('distributeur.historique');

// Route for show
Route::get('/distributeur/{id}', [DistributeurController::class, 'show'])->name('distributeur.show');



require __DIR__.'/auth.php';