<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DistributeurController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/index', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/clients', [DistributeurController::class, 'showClients'])->name('clients.index');
Route::get('/historique', [DistributeurController::class, 'showHistory'])->name('distributeur.history');
Route::get('/distributeur/{id}', [DistributeurController::class, 'show'])->name('distributeur.show');



// Route pour afficher la page de connexion
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});






// Route pour la vue distributeur
Route::get('/distributeur', [DistributeurController::class, 'index'])->name('distributeur');




Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');











// Route pour afficher le formulaire de dépôt
Route::get('/depot', function () {
    return view('depot');
});

// Route pour traiter le dépôt
Route::post('/depot', [TransactionController::class, 'depot'])->name('depot');

// Route pour afficher le formulaire de retrait
Route::get('/retrait', function () {
    return view('retrait');
});

// Route pour traiter le retrait
Route::post('/retrait', [TransactionController::class, 'retrait'])->name('retrait');





// Route pour afficher les transactions (historique)
Route::get('/transactions/{distributeurId}', [TransactionController::class, 'index'])->name('historiques.index');

// Route pour annuler une transaction
Route::delete('/transactions/{transactionId}/{distributeurId}', [TransactionController::class, 'cancel'])
    ->name('transactions.cancel');



require __DIR__.'/auth.php';
