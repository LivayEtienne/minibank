<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatistiqueController;

Route::get('/', function () {
    return view('welcome');
});


// Route pour afficher le formulaire d'inscription
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
Route::get('/creer_compte', function () {
    return view('auth.register');
})->name('creer_compte');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
