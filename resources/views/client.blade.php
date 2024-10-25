<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard client</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @vite(['resources/css/client.css'])
</head>
<body>

<div class="nav">
    <div class="container-fluid text-white p-3 d-flex justify-content-between align-items-center custom-bg-blue">
        <h1>MINIBANK</h1>
        <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px; height: auto;">
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Historique Section -->
        <div class="col-md-4 mb-4">
    <div class="historique">
        <h2 class="text-center">HISTORIQUES</h2>
        @if ($transactions->isEmpty())
            <p>Aucune transaction</p>
        @else
            @foreach($transactions as $transaction)
                <div class="list-group-item mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Prénom et Nom sur la même ligne -->
                        <div class="transaction-info">
                            <h5 class="mb-0">{{ $transaction->prenom_source }} {{ $transaction->nom_source }} {{ $transaction->telephone }}</h5>
                            
                        </div>
                        <!-- Montant aligné à droite -->
                        <span>{{ $transaction->montant }}</span>
                    </div>
                    <ul>
                        <li>{{ $transaction->date }}</li>
                    </ul>
                </div>
            @endforeach
        @endif
    </div>
</div>




        <!-- Carte Section -->
        <div class="col-md-6 offset-md-2 mb-4">

        <!-- SOLDE -->
        <div class="solde">
        <i class="fas fa-eye toggle-button" id="toggle"></i>
            <span class="montant" id="montant">*********** </span>
            
        </div>
            <div class="carte1">
                
            </div>
            <button class="btn">TRANSFERER</button>
        </div>
    </div>
</div>

@vite(['/resources/js/client.js'])   
</body>
</html>
