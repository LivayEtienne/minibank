
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Distributeur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @vite(['resources/css/distributeur.css'])

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
                    const montant = document.getElementById('montant');
                    const montantVisible = document.getElementById('montant-visible');
                    const toggleIcon = document.getElementById('toggle');

                    if (montant.style.display === 'none') {
                        montant.style.display = 'inline';
                        montantVisible.style.display = 'none';
                        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
                    } else {
                        montant.style.display = 'none';
                        montantVisible.style.display = 'inline';
                        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
                    }
                }
            </script>
                    <div class="operation">               
                     <button class="depot">DEPOT</button>
                      <button class="retrait">RETRAIT</button>
                    </div>                                          
        </div>
    </div>
</div>



@vite(['/resources/js/distributeur.js'])
</body>
</html>
