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
        <a class="nav-link text-light" href="{{ route('logout')}}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
            <i class="fas fa-credit-card"></i> Deconnexion
        </a>
    </div>
</div>


<div class="container mt-4">
    <div class="row">
        <!-- Historique Section -->
        <div class="col-md-4 mb-4">
        <div class="col-md-4 mb-4">
            <div class="historique">
                <h2 class="text-center">HISTORIQUES</h2>
                @if (empty($transactions))
                    <p>Aucune transaction enregistrée.</p>
                @endif
                    @foreach($transactions as $transaction)
                        <div class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="transaction-info">
                                    <h5 class="mb-0"> <span>{{ $transaction->prenom_source }} {{ $transaction->nom_source }} {{ $transaction->telephone }}</span></h5>
                                    {{ $transaction->type }}
                                </div>
                                <span>
                                @if ($transaction->type == 'depot')
                                    +{{ $transaction->montant }}
                                @elseif ($transaction->type == 'retrait' || $transaction->type == 'envoi')
                                    -{{ $transaction->montant .'F' }}
                                @else
                                    {{ $transaction->montant }}
                                @endif
                                </span>
                            </div>
                            <ul>
                                {{ $transaction->date }} 
                            </ul>
                        </div>
                    @endforeach
                
            </div>
</div>




        <!-- Carte Section -->
        <div class="col-md-6 offset-md-2 mb-4">

        <!-- SOLDE -->
        <div class="solde">
    <i class="fas fa-eye toggle-button" id="toggle" onclick="toggleSolde()"></i>
    <span class="montant" id="montant">***********</span>
    <span class="montant-visible" id="montant-visible" style="display: none;">{{ $solde }} FCFA</span>
</div>

<script>
    function toggleSolde() {
        // Sélection des éléments avec les montants caché et visible
        const montant = document.getElementById('montant');
        const montantVisible = document.getElementById('montant-visible');
        const toggleIcon = document.getElementById('toggle');

        // Toggle entre le montant caché et visible
        if (montant.style.display === 'none') {
            montant.style.display = 'inline'; // Afficher les étoiles
            montantVisible.style.display = 'none'; // Cacher le montant réel
            toggleIcon.classList.replace('fa-eye-slash', 'fa-eye'); // Changer l'icône pour "voir"
        } else {
            montant.style.display = 'none'; // Cacher les étoiles
            montantVisible.style.display = 'inline'; // Afficher le montant réel
            toggleIcon.classList.replace('fa-eye', 'fa-eye-slash'); // Changer l'icône pour "cacher"
        }
    }
</script>

            <div class="carte1">
                
            <img src="{{ $qrCode }}" alt="QR Code du client" class="img-fluid" >  
            </div>
            <a href="{{ route('transactions.transfer') }}"><button class="btn">TRANSFERER</button></a>
        </div>
    </div>
</div>


@vite(['/resources/js/client.js'])   
</body>
</html>
