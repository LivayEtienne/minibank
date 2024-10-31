<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard client</title>
    @vite(['resources/css/client.css'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
         body {
            background-color: #f8f9fa; /* Couleur de fond légère */
        }
        .historique {
            padding: 20px;
            border-radius: 8px;
            color: #2F2F2F; /* Texte en blanc pour le contraste */
            margin-top: 15px;
           
            
        }
        .historique h2 {
            background-color: orange; /* Fond orange pour la section historique */
            margin-bottom: 20px;
            color: white;

        }
        .sectionHistoric{
            display: flex;
            align-items: flex-start; /* Centrer les éléments horizontalement */
            justify-content: center; /* Commencer par le haut */
            margin-bottom: 5px;
            margin-left: 10%;
        }
        .solde {
            display: flex;
            margin-bottom: 20px;
        }
        .montant, .montant-visible {
            font-size: 24px; /* Taille de police pour le montant */
            font-weight: bold; /* Rendre le texte en gras */
        }
        .sectionSolde {
            margin-left: 10%; 
        }
        .carte1 {
            text-align: center; /* Centrer l'image du QR code */
            display: flex;
            flex-direction: column; /* Disposer les éléments en colonne */
            align-items: center; /* Centrer les éléments horizontalement */
            justify-content: flex-start; /* Commencer par le haut */
            padding: 20px; /* Ajoute un peu d'espace à l'intérieur */
            background-color: #f0f0f2 ; /* Couleur de fond pour la carte */
            border-radius: 8px; /* Coins arrondis */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Ombre pour effet de profondeur */
        }

        .modal.fade .modal-dialog {
            -webkit-animation: fadeIn 1s forwards; /* Augmentation de la durée à 1s */
            animation: fadeIn 1s forwards; /* Augmentation de la durée à 1s */
        }

        @keyframes fadeIn {
            from {
            opacity: 0;
            transform: translate(0, -50%);
            }
            to {
            opacity: 1;
            transform: translate(0, 0);
            }
        }
    </style>
</head>
<body>

<div class="nav ">
    <div class="container-fluid text-white p-3 d-flex justify-content-between align-items-center custom-bg-blue">
        <h1>MINIBANK</h1>
        <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px; height: auto;">
        <a class="nav-link text-light" href="{{ route('logout')}}" onmouseover="this.classList.add('bg-primary');" onmouseout="this.classList.remove('bg-primary');">
            <i class="fas fa-credit-card"></i> Deconnexion
        </a>
    </div>
</div>

<div class="container-fluid mt-5"> <!-- Changer ici -->
    <div class="row">
        <!-- Carte Section (à gauche) -->
        <div class="col-md-5 mb-4 sectionSolde">
            <div class="solde">
                <span class="montant" id="montant">***********</span>
                <span class="montant-visible" id="montant-visible" style="display: none; font-size: 2rem;">{{ $solde }} F CFA</span>
                <i class="fas fa-eye toggle-button ml-2" id="toggle" onclick="toggleSolde()"></i>
            </div>
            <div class="carte1">
                <img src="{{ $qrCode }}" alt="QR Code du client" class="img-fluid">  
            </div>
            <div class="mt-5">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#transferModal">
                    TRANSFERE
                </button>
            </div>
        </div>

        <!-- Historique Section (à droite) -->
        <div class="col-md-3 mb-4 sectionHistoric">
            <div class="historique">
                <h2 class="text-center">HISTORIQUES</h2>
                @if (empty($transactions))
                    <p>Aucune transaction enregistrée.</p>
                @else
                    @foreach($transactions as $transaction)
                   <?php $sourceUser = $transaction->sourceUser; // Utilisateur source
                         $destinationUser = $transaction->destinationUser; // Utilisateur destinataire
                    ?>
                        <div class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="transaction-info">
                                    @if ($transaction->type == 'envoi')
                                    <a href="" data-toggle="modal2" data-target="#transactionModal{{ $transaction->id }}"><h5 class="mb-0"><span>{{ $destinationUser->prenom }} {{ $destinationUser->nom }} {{ $destinationUser->telephone }}</span></h5></a>
                                        {{ $transaction->type }}
                                    @endif
                                    @if ($transaction->type == 'depot' || $transaction->type == 'retrait')
                                    <a href="" data-toggle="modal2" data-target="#transactionModal{{ $transaction->id }}"> <h5 class="mb-0"><span>{{ $sourceUser->prenom }} {{ $sourceUser->nom }} {{ $sourceUser->telephone }}</span></h5></a>
                                        {{ $transaction->type }}
                                    @endif
                                   
                                </div>
                                <span>
                                    @if ($transaction->type == 'depot' || $transaction->type == 'recue' || $transaction->type == 'annule')
                                        +{{ $transaction->montant }}
                                    @elseif ($transaction->type == 'retrait' || $transaction->type == 'envoi')
                                        -{{ $transaction->montant .'F' }}
                                    @else
                                        {{ $transaction->montant }}
                                    @endif
                                </span>
                            </div>
                            <ul>
                                {{ $transaction->created_at }} 
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Modal pour les messages -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="messageContent"></div> <!-- Contenu du message ici -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Transfer -->
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferModalLabel">Transférer de l'argent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="transferForm" method="POST" action="{{ route('transaction.transfer') }}">
                    @csrf <!-- Token CSRF pour la sécurité -->
                    <div class="form-group">
                        <label for="recipientPhone">Numéro de téléphone</label>
                        <input type="tel" class="form-control" id="recipientPhone" name="telephone" placeholder="Entrez le numéro de téléphone" required>
                        <small class="text-danger" id="phoneError"></small> <!-- Message d'erreur pour le téléphone -->
                    </div>
                    <div class="form-group">
                        <label for="transferAmount">Montant à transférer</label>
                        <input type="number" class="form-control" id="transferAmount" name="montant" placeholder="Entrez le montant" min="500" required>
                        <small class="text-danger" id="amountError"></small> <!-- Message d'erreur pour le montant -->
                    </div>
                    <div class="form-group">
                        <div id="totalDebit" class="font-weight-bold"></div> <!-- Affichage du montant débité -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="submitTransfer">Transférer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal affiche détails -->
<div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Détails de la transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               @if ($transaction->type === "envoi")
                <p><strong>Prénom :</strong> {{ $transaction->sourceUser->prenom }}</p>
                <p><strong>Nom :</strong> {{ $sourceUser->nom }}</p>
                <p><strong>Numéro de téléphone :</strong> {{ $sourceUser->telephone }}</p>
               
               @endif

               @if ($transaction->type == 'recue' || $transaction->type == 'depot' || $transaction->type == 'retrait')
                <p><strong>Prénom :</strong> {{ $transaction->destinationUser->prenom }}</p>
                <p><strong>Nom :</strong> {{ $transaction->destinationUser->nom }}</p>
                <p><strong>Numéro de téléphone :</strong> {{ $transaction->destinationUser->telephone }}</p>
               
               @endif

               
      

                <p><strong>Type de transaction :</strong> {{ $transaction->type }}</p>
                <p><strong>Montant :</strong> {{ $transaction->montant }}</p>
                <p><strong>Heure de la transaction :</strong> {{ $transaction->created_at }}</p>
            </div>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
 
    const solde = <?= $solde; ?>; // Correctly define the variable in JavaScript using PHP's echo
    const fraisPourcentage = 0.02; // 2% de frais

    document.getElementById('recipientPhone').addEventListener('input', function() {
        const phoneInput = this.value;
        const phoneError = document.getElementById('phoneError');

        // Vérification des chiffres
        if (!/^\d{9}$/.test(phoneInput)) {
            phoneError.textContent = "Le numéro de téléphone doit contenir uniquement des chiffres et 9 chiffres.";
        } else {
            phoneError.textContent = ""; // Efface le message d'erreur si valide
        }
    });

    

    document.getElementById('transferAmount').addEventListener('input', function() {
        const amountInput = this.value;
        const amountError = document.getElementById('amountError');
        const amount = parseFloat(amountInput);
        const totalDebitElement = document.getElementById('totalDebit');

         // Vérification si le montant contient uniquement des chiffres
         if (!/^\d*\.?\d+$/.test(amountInput)) {
            amountError.textContent = "Le montant doit contenir uniquement des chiffres.";
         }
        else if (amount < 500) { // Vérification du montant
            amountError.textContent = "Le montant doit être d'au moins 500.";
        } else if (amount >= solde * 1.02) {
            amountError.textContent = "Le montant doit être inférieur à votre solde plus 2% des frais.";
        }
         else {
            amountError.textContent = ""; // Efface le message d'erreur si valide
        }

         // Vérification si le montant est valide
        if (!isNaN(amountInput) && amountInput >= 500) {
            const montant = parseFloat(amountInput);
            const frais = montant * fraisPourcentage;
            const totalDebit = montant + frais;

            // Affichage du montant débité
            totalDebitElement.textContent = "Montant débité : " + totalDebit.toFixed(2) + " F CFA";
        } else {
            totalDebitElement.textContent = ""; // Efface le texte si le montant n'est pas valide
        }
    });

    document.getElementById('submitTransfer').addEventListener('click', function() {
        const phoneError = document.getElementById('phoneError').textContent;
        const amountError = document.getElementById('amountError').textContent;

        // Vérifie s'il y a des erreurs avant de soumettre le formulaire
        if (!phoneError && !amountError) {
            document.getElementById('transferForm').submit();
        }
    });

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
  
    $(document).ready(function() {
        // Vérifie s'il y a un message de succès
        @if(session('success'))
            $('#messageContent').html('<div class="alert alert-success">{{ session('success') }}</div>');
            $('#messageModal').modal('show');
        @endif

        // Vérifie s'il y a un message d'erreur
       
        @if(session('error'))
        $('#messageContent').html('<div class="alert alert-danger">{{ session('error') }}</div>');
        $('#messageModal').modal('show');
        @endif
    });

    $(document).ready(function() {
        $('a[data-toggle="modal2"]').click(function() {
            var target = $(this).data('target');
            $(target).modal('show');
        });
    });
</script>


</body>
</html>