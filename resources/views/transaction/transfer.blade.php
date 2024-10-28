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
        <div class="col-md-3 mb-4">
    <div class="historique">
        <h2 class="text-center">TRANSFER</h2>
        <div class="col-md-5 mb-3">
            <div class="mt-5 justify-content-center">
                <form action="{{ route('transaction.transfer')}}" method="POST">
                    @csrf
                    <div class="mt-5 justify-content-center">
                        <label for="telephone">Entrer le numero du Client</label>
                        <input type="number" name="telephone" placeholder="Entrer le numero" required>
                    </div>
                    <div class="mt-5 justify-content-center">
                        <label for="montant">Entrer le montant a Transferer</label>
                        <input type="number" name="montant" placeholder="Entrer le montant" min="500" required >
                    </div>
                    <div class="mt-5 justify-content-center">
                        <button>Annuler</button>
                        <button type="submit" class="ml-5 " >Valider</button> 
                    </div>
                </form>
            </div>
        </div>
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
            <button class="btn">TRANSFERER</button>
        </div>
    </div>
</div>


@vite(['/resources/js/client.js'])   
</body>
</html>
