<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @vite(['resources/css/distributeur.css'])
</head>
<body>

    <div class="nav d-flex justify-content-between align-items-center p-3">
        <h1 class="text-white">MINIBANK</h1>
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="img-fluid" style="max-width: 150px; height: auto;" />
        <a class="nav-link text-light" href="{{ route('logout')}}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                        <i class="fas fa-credit-card"></i> Deconnexion
        </a>
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Section Historique -->
            <div class="col-md-4 mb-3">
                <div class="historique">
                    <h2>HISTORIQUES</h2>
                </div>
                 @if ($transactions->isEmpty())
                    <p class="mt-5 justify-content-center">Aucune transaction</p>
                @else
                    @foreach($transactions as $transaction)
                        <div class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Prénom et Nom sur la même ligne -->
                                <div class="transaction-info">
                                    <h5 class="mb-0"> <span>{{ $transaction->prenom_source }} {{ $transaction->nom_source }} {{ $transaction->telephone }}</span></h5>
                                    {{ $transaction->type }}
                                </div>
                                <!-- Montant aligné à droite -->
                                <span>
                                @if ($transaction->type == 'depot')
                            +{{ $transaction->montant }}
                        @elseif ($transaction->type == 'retrait' || $transaction->type == 'envoi')
                            -{{ $transaction->montant .'F' }}
                        @else
                            {{ $transaction->montant }} <!-- Pour les autres types, afficher sans signe -->
                        @endif
                                    </span>
                            </div>
                            <ul>
                                {{ $transaction->date }} 
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Section Opérations -->
            <div class="col-md-8 mb-3">
                <div class="operation text-center">
                    <!-- Section Solde -->
                    <div class="solde mt-3">
                        <i class="fas fa-eye toggle-button" id="toggle"></i>
                        <span class="montant" id="montant">*********** </span>
                    </div>
                    <a href="{{ route('transactions.depot') }}"><button class="retrait btn btn-primary m-2" >DEPOT</button></a>
                    <a href="{{ route('transactions.retrait') }}"><button class="depot btn btn-success m-2" >RETRAIT</button></a>

                    
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/client.js'])  
</body>
</html>
