<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\agentController;
use App\Http\Controllers\distributeurController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route pour afficher le dashboard du client

Route::get('/client', [\App\Http\Controllers\ClientController::class, 'index']);


// Route pour afficher le dashboard du distributeur

Route::get('distributeur', [distributeurController::class, 'index']);


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
});

require __DIR__.'/auth.php';
