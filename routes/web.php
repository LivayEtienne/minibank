<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRCodeController;

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

Route::get('/qr-code/{id}', [QRCodeController::class, 'generate'])->name('qr.code');
Route::get('/qr-code/{id}/refresh', [QRCodeController::class, 'getQRCode']);

require __DIR__.'/auth.php';

/*Route::get('/agent/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/client/dashboard', [ClientController::class, 'index'])->name('client.dashboard')->middleware('auth');
Route::get('/distributeur/dashboard', [DistributeurController::class, 'index'])->name('distributeur.dashboard')->middleware('auth');*/