<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Distributeur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @vite(['resources/css/distributeur.css'])
    <style>
        body {
            overflow: hidden; /* Éliminer le défilement vertical */
            font-family: 'Georgia', serif; /* Appliquer la police Georgia */
        }

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

        .nav-link.logout {
            color: red; /* Couleur rouge pour le lien de déconnexion */
        }

        .card-body {
            color: black;
            border: 2px solid #f8f9fa;
            background-color: #ffffff;
            
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            padding: 15px
        }

        .solde-card {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            display: flex;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            height: 200px;
            width: 100%; /* Prend toute la largeur de la colonne */
            height: 150px
        }

        .solde-card .card-title {
            font-size: 1.em;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .solde-text {
            font-size: 1.2em; /* Augmenter la taille de la police */
            font-weight: bold;
            color: #007bff; /* Bleu pour mettre en avant le solde */
            background-color: #e9f7fe; /* Couleur de fond légèrement bleutée */
            padding: 15px 25px; /* Espacement autour du texte */
            border-radius: 10px; /* Bordures arrondies autour du solde */
            display: inline-block;
        }

        .qr-code-container {
            background-color: #003366; /* Couleur de fond */
            display: inline-block; /* Permet à la div de s'adapter à son contenu */
            padding: 20px; /* Espacement intérieur */
            text-align: center; /* Centrer le contenu, si nécessaire */
            border-radius: 5px;
        }

        .montant, .montant-visible {
            font-size: 2rem; /* Augmenter la taille de la police pour le solde */
            font-weight: bold; /* Rendre le texte en gras */
        }

        .toggle-button {
            font-size: 2rem; /* Augmenter la taille de l'icône de l'œil */
            cursor: pointer; /* Changer le curseur en pointeur */
            margin-left: 10px; /* Espacement entre montant et icône */
        }

        .custom-table {
            border: 1px solid #ddd;
            border-collapse: collapse;
            font-family: 'Georgia', serif; /* Appliquer la police Georgia au tableau */
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #f8f9fa;
            color: #495057;
        }

        .custom-table tr:hover {
            background-color: #f1f1f1;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
        }

        .pagination a,
        .pagination span {
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            border: 1px solid #007BFF;
            color: #007BFF;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }

        .pagination .active {
            background-color: #007BFF;
            color: white;
            border: none;
        }

        .pagination .disabled {
            color: #ccc;
            pointer-events: none;
        }

        @media (max-width: 576px) {
            .solde-content {
                font-size: 1.5rem; /* Ajuster la taille de police pour les petits écrans */
            }
        }

        .content {
            margin-left: 0;
            padding: 20px;
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
                <a class="nav-link" href="#">
                    <i class="fas fa-users"></i> Clients
                </a>
            </li>
            <li class="nav-item" style="margin-top: auto;"> <!-- Ajout de margin-top:auto pour pousser le lien de déconnexion en bas -->
                <a class="nav-link logout" href="{{ route('logout') }}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
                    <i class="fas fa-sign-out-alt"></i> Deconnexion
                </a>
            </li>
        </ul>
    </div>

    <div class="content" style="margin-left: 250px; padding-top: 10px; ;">
   
        <!-- Section pour les statistiques -->
        <div class="row text-center mb-4 g-3">
            <div class="col-md">
                <div class="card solde-card ">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Transactions</h5>
                        <p class="card-text solde-text">{{ $transactionCounts['nombreTransactions']  }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card solde-card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Dépôts</h5>
                        <p class="card-text solde-text">{{ $transactionCounts['nombreDepots']  }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card solde-card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de Retraits</h5>
                        <p class="card-text solde-text">{{ $transactionCounts['nombreRetraits']  }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Section -->
        <div class="col-md-6 offset-md-3 mb-4">
            <div class="solde text-center mb-4" style="position: relative;">
                <div class="solde-content">
                    <span class="montant" id="montant">***********</span>
                    <span class="montant-visible" id="montant-visible" style="display: none;">{{ $solde }} FCFA</span>
                    <i class="fas fa-eye toggle-button" id="toggle" onclick="toggleSolde()"></i>
                </div>
                <div class="qr-code-container">
                    <img src="{{ asset('images/1.png') }}" alt="code QRcode" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <!-- Operations Section -->
                <div class="col-md-12 mb-4 text-center">
                    <div class="operation text-center">
                        <button class="btn btn-primary m-2" data-toggle="modal" data-target="#depotModal">DEPOT</button>
                        <button class="btn btn-success m-2" data-toggle="modal" data-target="#retraitModal">RETRAIT</button>
                    </div>
                </div>
            </div>
            @section('content')
<div class="container">
    <!-- Affichage des messages de session -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
   
<!-- Depot Modal -->
<div class="modal fade" id="depotModal" tabindex="-1" role="dialog" aria-labelledby="depotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depotModalLabel">Transaction (Dépôt)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaction.depot') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="telephone">Entrer le numéro du Client</label>
                        <input type="text" class="form-control" name="telephone" placeholder="Entrer le numéro">
                        <div class="error-message text-danger"></div>  <!-- Zone pour les messages d'erreur -->
                    </div>
                    <div class="form-group">
                        <label for="montant">Entrer le montant à déposer</label>
                        <input type="number" class="form-control" name="montant" placeholder="Entrer le montant"  >
                        <div class="error-message text-danger"></div>  <!-- Zone pour les messages d'erreur -->
                    </div>
                    <button type="submit" class="btn btn-primary">Effectuer le Dépôt</button>
                </form>
            </div>
        </div>
    </div>
</div>



            

          <!-- Retrait Modal -->
<div class="modal fade" id="retraitModal" tabindex="-1" role="dialog" aria-labelledby="retraitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="retraitModalLabel">Transaction (Retrait)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaction.retrait') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="telephone">Entrer le numéro du Client</label>
                        <input type="text" class="form-control" name="telephone" placeholder="Entrer le numéro" >
                        <div class="error-message text-danger"></div> <!-- Zone pour les messages d'erreur -->
                    </div>
                    <div class="form-group">
                        <label for="montant">Entrer le montant à retirer</label>
                        <input type="number" class="form-control" name="montant" placeholder="Entrer le montant"  >
                        <div class="error-message text-danger"></div> <!-- Zone pour les messages d'erreur -->
                    </div>
                    <button type="submit" class="btn btn-success">Effectuer le Retrait</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-hover custom-table">
        <thead class="thead-light">
            <tr>
                <th>Nom du Client</th>
                <th>Téléphone</th>
                <th>Numéro de Compte</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($transactions) && count($transactions) > 0)
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->clientSource->user ? $transaction->clientSource->user->prenom . ' ' . $transaction->clientSource->user->nom : 'N/A' }}</td>
                        <td>{{ $transaction->clientSource->user ? $transaction->clientSource->user->telephone : 'N/A' }}</td>
                        <td>{{ $transaction->clientSource->numero_compte }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ number_format($transaction->montant, 2, ',', ' ') }} F</td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($transaction->statut == 'annulé')
                                <span style="color: red;">Annulé</span>
                            @else
                                <span style="color: #027A48;">Validé</span>
                            @endif
                        </td>
                        <td>
                            @if($transaction->type == 'depot')
                                <form action="{{ route('transactions.annulerDepot', $transaction->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce dépôt ?');">Annuler Dépôt</button>
                                </form>
                            @elseif($transaction->type == 'retrait')
                                <form action="{{ route('transactions.annulerRetrait', $transaction->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce retrait ?');">Annuler Retrait</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Aucune transaction trouvée.</td>
                </tr>
            @endif    
        </tbody>
    </table>
</div>


<!-- Pagination -->
<div class="pagination-wrapper">
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($transactions->onFirstPage())
            <span class="disabled">&laquo;</span>
        @else
            <a href="{{ $transactions->previousPageUrl() }}" rel="prev">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($transactions as $transaction)
            @if (is_string($transaction))
                <span class="disabled">{{ $transaction }}</span>
            @endif

            @if (is_array($transaction))
                @foreach ($transaction as $page => $url)
                    @if ($page == $transactions->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($transactions->hasMorePages())
            <a href="{{ $transactions->nextPageUrl() }}" rel="next">&raquo;</a>
        @else
            <span class="disabled">&raquo;</span>
        @endif
    </div>
</div>

</div>

            </div>
        </div>
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
        
        document.addEventListener("DOMContentLoaded", function() {
    const depotForm = document.querySelector("#depotModal form");
    const retraitForm = document.querySelector("#retraitModal form");

    // Validation pour le dépôt
    depotForm.addEventListener("submit", function(event) {
        const montant = depotForm.querySelector("input[name='montant']");
        const telephone = depotForm.querySelector("input[name='telephone']");
        
        document.querySelectorAll(".error-message").forEach(function(elem) {
            elem.textContent = '';
        });

        let valid = true;

        if (!montant.value) {
            valid = false;
            montant.parentNode.querySelector(".error-message").textContent = "Le montant est requis.";
        } else if (isNaN(montant.value) || montant.value < 500) {
            valid = false;
            montant.parentNode.querySelector(".error-message").textContent = "Le montant doit être au moins 500.";
        }

        if (!telephone.value) {
            valid = false;
            telephone.parentNode.querySelector(".error-message").textContent = "Le numéro de téléphone est requis.";
        } else if (!/^\d{9}$/.test(telephone.value)) {
            valid = false;
            telephone.parentNode.querySelector(".error-message").textContent = "Le numéro de téléphone doit comporter 9 chiffres.";
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    // Validation pour le retrait
    retraitForm.addEventListener("submit", function(event) {
        const montant = retraitForm.querySelector("input[name='montant']");
        const telephone = retraitForm.querySelector("input[name='telephone']");
        
        document.querySelectorAll(".error-message").forEach(function(elem) {
            elem.textContent = '';
        });

        let valid = true;

        if (!montant.value) {
            valid = false;
            montant.parentNode.querySelector(".error-message").textContent = "Le montant est requis.";
        } else if (isNaN(montant.value) || montant.value < 500) {
            valid = false;
            montant.parentNode.querySelector(".error-message").textContent = "Le montant doit être au moins 500.";
        }

        if (!telephone.value) {
            valid = false;
            telephone.parentNode.querySelector(".error-message").textContent = "Le numéro de téléphone est requis.";
        } else if (!/^\d{9}$/.test(telephone.value)) {
            valid = false;
            telephone.parentNode.querySelector(".error-message").textContent = "Le numéro de téléphone doit comporter 9 chiffres.";
        }

        // Vérification de l'existence du numéro de téléphone dans la base de données (côté client seulement si nécessaire)
        // Il serait préférable de faire cela côté serveur pour éviter les failles de sécurité.

        if (!valid) {
            event.preventDefault();
        }
    });
});


    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @vite(['/resources/js/distributeur.js'])
</body>
</html>
