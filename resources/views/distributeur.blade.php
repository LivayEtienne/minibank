<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Distributeur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /* Sidebar */
        .sidebar {
            background-color: #003366;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            color: white;
            padding-top: 120px;
        }

        .sidebar .nav-link {
            color: #ffffff;
            padding: 10px 20px;
            font-size: 1.1em;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #005b99;
            font-weight: bold;
        }

        /* Main Content */
        .content {
            margin-left: 250px;
            padding: 100px;
            overflow-y: auto;
            height: 100vh;
            background-color: #f8f9fa;
        }

        /* Transaction Section */
        .transaction-section {
            margin-top: 30px;
            max-width: 600px; /* Increased max width for better visibility */
            background-color: #e9ecef; /* Background color for the transaction section */
            padding: 50px; /* Padding for the section */
            border-radius: 5px; /* Optional: add rounded corners */
            display: flex; /* Flexbox for centering content */
            flex-direction: column; /* Column layout */
            align-items: center; /* Center the content horizontally */
            justify-content: center; /* Center the content vertically */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: add a subtle shadow */
        }

        .transaction-section h5 {
            font-weight: bold;
            margin-bottom: 20px;
            background: blue;
            color: white; /* Change text color to white */
            padding: 10px; /* Add padding around the text */
            font-size: 1.5em; /* Increase font size */
             /* Optional: add rounded corners */
            text-align: center; /* Center the text */
            width: 60%; /* Full width for the header */
        }

        .transaction-buttons {
            display: flex; /* Align buttons in a row */
            gap: 30px; /* Adjusted gap between buttons */
            margin-top: 20px; /* Added margin for space above buttons */
        }

        .transaction-section .btn {
            width: 170px; /* Increased button width */
            font-size: 1.2em; /* Increase font size for buttons */
            /* Remove hover effect */
            transition: none; 
        }
        .card-body {
        color: black;
        border: 2px solid white; /* Bordure blanche de 2 pixels */
        background-color: #eaeaea; /* Couleur de fond blanche */
        padding: 70px; /* Padding pour la section */
        border-radius: 10px; /* Coins arrondis */
        display: flex; /* Flexbox pour centrer le contenu */
        flex-direction: column; /* Disposition en colonne */
   
        }

    
        
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('distributeur') }}">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('historiques.index') }}">
                    <i class="fas fa-users"></i> Historique
                </a>
            </li>
            
        </ul>
    </div>

    <!-- Main Content -->
   <!-- Main Content -->
<div class="content">
    <!-- Affichage des Messages de Succès et d'Erreur -->
    @if (session('message'))
        <div class="alert alert-success mt-3">{{ session('message') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <!-- Statistiques -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="">
                <div class="card-body">
                    <h5 class="class= fas fa-users">Total des Clients</h5>
                    <p class="card-text">150</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="">
                <div class="card-body">
                    <h5 class="card-title">Nombre de transactions</h5>
                    <p class="card-text">200</p>
                </div>
            </div>
        </div>
       
    </div>

    <!-- Transaction Section -->
    <div class="transaction-section">
        <h5>TRANSACTION</h5>
        <div class="transaction-buttons">
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#depotModal">DEPOT</button>
            <button class="btn btn-outline-danger" data-toggle="modal" data-target="#retraitModal">RETRAIT</button>
        </div>
    </div>
</div>

<!-- Modal Dépôt -->
<div class="modal fade" id="depotModal" tabindex="-1" role="dialog" aria-labelledby="depotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depotModalLabel">Formulaire de Dépôt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('depot') }}" method="POST" class="text-center">
                    @csrf
                    <div class="form-group">
                        <label for="numero_compte_depot">Numéro de Compte:</label>
                        <input type="text" class="form-control small-input" id="numero_compte_depot" name="numero_compte" required>
                    </div>

                    <div class="form-group">
                        <label for="montant_depot">Montant:</label>
                        <input type="number" class="form-control small-input" id="montant_depot" name="montant" required min="1" step="0.01">
                    </div>

                    <button type="submit" class="btn btn-primary">Déposer</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Retrait -->
<div class="modal fade" id="retraitModal" tabindex="-1" role="dialog" aria-labelledby="retraitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="retraitModalLabel">Formulaire de Retrait</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('retrait') }}" method="POST" class="text-center">
                    @csrf
                    <div class="form-group">
                        <label for="numero_compte_retrait">Numéro de Compte:</label>
                        <input type="text" class="form-control small-input" id="numero_compte_retrait" name="numero_compte" required>
                    </div>

                    <div class="form-group">
                        <label for="montant_retrait">Montant:</label>
                        <input type="number" class="form-control small-input" id="montant_retrait" name="montant" required min="1" step="0.01">
                    </div>

                    <button type="submit" class="btn btn-primary">Retirer</button>
                   
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
    
