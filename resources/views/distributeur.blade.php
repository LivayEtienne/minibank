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
        <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px; height: auto;">
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Section Historique -->
            <div class="col-md-4 mb-3">
                <div class="historique p-1">
                    <h2>HISTORIQUES</h2>
                    <ul>
                        <!-- Historique peut être ajouté ici -->
                    </ul>
                </div>
            </div>

            <!-- Section Opérations -->
            <div class="col-md-8 mb-3">
                <div class="operation text-center">
                    <!-- Section Solde -->
                    <div class="solde mt-3">
                        <i class="fas fa-eye toggle-button" id="toggle"></i>
                        <span class="montant" id="montant">*********** </span>
                    </div>
                    <a class="retrait btn btn-primary m-2" href="#">RETRAIT</a>
                    <a class="depot btn btn-success m-2" href="#">DEPOT</a>

                    
                </div>
            </div>
        </div>
    </div>

    @vite(['/resources/js/client.js'])   
</body>
</html>
