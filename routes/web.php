<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('agent/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('agent.dashboard');


Route::get('/index', [DashboardController::class, 'index'])->name('dashboard');

// Route pour afficher la page de connexion
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Autres routes...

Route::get('/transactions/transfer', function () {
    $distributeurs = \App\Models\User::where('role', 'distributeur')->get(); // Récupérer les distributeurs
    return view('transaction', compact('distributeurs'));
})->name('transactions.transferForm');

Route::post('/transactions/transfer', [TransactionController::class, 'transferFromAgentToDistributeur'])
    ->name('transactions.transferToDistributeur');

// Route pour afficher le formulaire de dépôt et retrait
Route::get('/distributeur/operations', function () {
    $clients = \App\Models\User::where('role', 'client')->get(); // Récupérer les clients
    return view('transaction', compact('clients'));
})->name('distributeur.operations');

// Route pour le dépôt
Route::post('/distributeur/depot', [TransactionController::class, 'transferFromDistributeurToClient'])
    ->name('distributeur.depot');

// Route pour le retrait
Route::post('/distributeur/retrait', [TransactionController::class, 'withdrawForDistributeur'])
    ->name('distributeur.retrait');


require __DIR__.'/auth.php';

/*Route::get('/agent/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/client/dashboard', [ClientController::class, 'index'])->name('client.dashboard')->middleware('auth');
Route::get('/distributeur/dashboard', [DistributeurController::class, 'index'])->name('distributeur.dashboard')->middleware('auth');*/