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

    <div class="nav">
        <h1>MINIBANK</h1>
        <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Logo" width="150px" height="125px">

    </div>

    <div class="container">
        <div class="historique">
            <h2>HISTORIQUES</h2>
            <ul>
                <!-- Historique peut être ajouté ici -->
            </ul>
        </div>

        <!-- Les opérations côté client --->
        <div class="operation">
            <a class="retrait" href="#">RETRAIT</a>
            <a class="depot" href="#">DEPOT</a>

            <!-- SOLDE -->
            <div class="solde">
            <i class="fas fa-eye toggle-button" id="toggle"></i>
                <span class="montant" id="montant">*********** </span>
                
            </div>

            

                   
        </div>
    </div>

    @vite(['/resources/js/client.js'])   
</body>
</html>


