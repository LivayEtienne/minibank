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
                <div class="historique p-1">
                        <h2>Transaction (Depot)</h2> 
                </div>
                <div class="mt-5 justify-content-center">
                    <form action="{{ route('transaction.depot')}}" method="POST">
                        @csrf
                        <div class="mt-5 justify-content-center">
                            <label for="telephone">Entrer le numero du Client</label>
                            <input type="number" name="telephone" placeholder="Entrer le numero" required>
                        </div>
                        <div class="mt-5 justify-content-center">
                            <label for="montant">Entrer le montant a retirer</label>
                            <input type="number" name="montant" placeholder="Entrer le montant" min="500" required >
                        </div>
                        <div class="mt-5 justify-content-center">
                            <button>Annuler</button>
                            <button type="submit" class="ml-5 " >Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
          

            <!-- Section Opérations -->
            <div class="col-md-8 mb-3">
                <div class="operation text-center">
                    <!-- Section Solde -->
                    <div class="solde mt-3">
                        <i class="fas fa-eye toggle-button" id="toggle"></i>
                        <span class="montant" id="montant">*********** </span>
                    </div>
                    <div>
                        <button class="retrait btn btn-primary m-2" href="{{ route('transactions.depot') }}" disable>RETRAIT</button>
                        <button class="depot btn btn-success m-2" href="{{ route('transactions.retrait') }}" disable>DEPOT</button>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/client.js'])  
</body>
</html>
