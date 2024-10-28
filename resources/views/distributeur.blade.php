<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Distributeur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @vite(['resources/css/distributeur.css'])
    <style>
        /* Sidebar */
        .sidebar {
            background-color: #003366; /* Couleur principale de la sidebar */
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
            transition: background-color 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #005b99; /* Couleur au survol et active */
            font-weight: bold;
        }

        /* Main Content */
        .content {
            margin-left: 250px;
            padding: 40px;
            overflow-y: auto;
            height: 100vh;
            background-color: #f8f9fa; /* Couleur d'arrière-plan principale */
        }

        /* Card Styles */
        .card-body {
            color: black;
            border: 2px solid #f8f9fa; /* Bordure correspondant au fond */
            background-color: #ffffff; /* Fond de carte blanc pour un look propre */
            padding: 30px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;  
        }

        /* Transaction Section */
        .transaction-section {
            margin-top: 30px;
            max-width: 600px;
            background-color: #ffffff; /* Fond blanc pour la section de transaction */
            padding: 80px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée pour un effet de profondeur */
            text-align: center; /* Centre le contenu dans la section */
        }

        .transaction-section h5 {
    font-weight: bold;
    margin-bottom: 20px;
    background: #007bff; /* Couleur de fond bleue */
    color: white;
    padding: 10px;
    font-size: 1.5em;
    text-align: center;
    border-radius: 5px; /* Bordures arrondies pour le titre */
    width: 60%; /* Largeur du titre */
    margin: 10 auto; /* Centre le titre horizontalement */
}

        .transaction-buttons {
            display: flex;
            justify-content: center; /* Centre les boutons horizontalement */
            gap: 50px;
            margin-top: 20px;        
        }

        .transaction-section .btn {
            width: 170px;
            font-size: 1.2em;          
        }

        /* Style de la carte du solde */
        .solde-card {
            background-color: #f8f9fa; /* Couleur de fond douce pour la carte */
            border: 1px solid #ddd; /* Bordure légère */
            border-radius: 10px; /* Bordures arrondies */
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre subtile */
            text-align: center; /* Centrer le contenu */
            max-width: 850px; /* Limiter la largeur de la carte */
            margin: auto; /* Centrer la carte horizontalement */
        }

        /* Style du titre */
        .solde-card .card-title {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 10px;
        }

        /* Style du texte du solde */
        .solde-text {
            font-size: 2em; /* Augmenter la taille de la police */
            font-weight: bold;
            color: #007bff; /* Bleu pour mettre en avant le solde */
            background-color: #e9f7fe; /* Couleur de fond légèrement bleutée */
            padding: 10px 20px; /* Espacement autour du texte */
            border-radius: 10px; /* Bordures arrondies autour du solde */
            display: inline-block;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                height: auto;
                padding-top: 60px;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .transaction-section {
                width: 90%; /* Rendre la section de transaction plus large sur petits écrans */
            }
        }

        .btn-danger, .btn-outline-danger {
            background-color: #25CD25;
            color: white;
        }

        .btn-primary, .btn-outline-primary {
            background-color: #003366;
            color: white;
        }
        .img-fluid {
    max-width: 80%; /* Limite la largeur de l'image à 80% de son conteneur */
    height: auto;   /* Conserve le ratio d'aspect de l'image */
    position: absolute; /* Positionne l'image par rapport à la section */
    right: 50px;          /* Aligne l'image à droite */
    top: 50%;          /* Aligne verticalement l'image au milieu */
    transform: translateY(-50%); /* Centre verticalement l'image */
    width: 400px;      /* Largeur de l'image (ajustez selon vos besoins) */
}

.solde {
    text-align: right; /* Centre le texte et l'icône */
    margin-bottom: 0px; /* Espacement sous le solde */
    margin-right: 160px;
    margin-bottom: 60px;
    font-weight: bold;
}

.toggle-button {
    cursor: pointer; /* Change le curseur pour indiquer que l'élément est cliquable */
    margin-right: 5px; /* Espacement entre l'icône et le montant */
}

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('distributeur.history') }}">
                    <i class="fas fa-users"></i> Historiques
                </a>
            </li>          
        </ul>
    </div>

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
                <div class="card solde-card">
                    <div class="card-body">
                        <h5 class="card-title">Solde du Distributeur</h5>
                        <p class="card-text soldes-text">{{ str_pad(number_format($distributeur->solde, 0, ',', ' '), 5, '0', STR_PAD_LEFT) }} FCFA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="solde-card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Transactions</h5>
                        <p class="card-text solde-text">{{ $nombreTransactions }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="solde mt-3">
    <i class="fas fa-eye toggle-button" id="toggle" onclick="toggleMontant()"></i>
    <span class="montant" id="montant">{{ str_pad(number_format($distributeur->solde, 0, ',', ' '), 5, '0', STR_PAD_LEFT) }} FCFA </span>
     </div>

    <!-- Ajout d'une image -->
<div class="text-center mb-4">
    <img src="{{ asset('1.png') }}" alt="qrcode" class="img-fluid">
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
</forme>
                </div>
            </div>
        </div>
    </div>
   
    <script>
    let isVisible = true; // Variable pour garder la trace de l'état de visibilité

    function toggleMontant() {
        const montantElement = document.getElementById('montant');
        const toggleButton = document.getElementById('toggle');

        if (isVisible) {
            // Masquer le montant
            montantElement.textContent = '******** FCFA';
            toggleButton.classList.remove('fa-eye'); // Changer l'icône
            toggleButton.classList.add('fa-eye-slash');
        } else {
            // Afficher le montant
            montantElement.textContent = '{{ str_pad(number_format($distributeur->solde, 0, ',', ' '), 5, '0', STR_PAD_LEFT) }} FCFA';
            toggleButton.classList.remove('fa-eye-slash'); // Changer l'icône
            toggleButton.classList.add('fa-eye');
        }

        // Inverser l'état de visibilité
        isVisible = !isVisible;
    }
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
