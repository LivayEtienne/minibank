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
    <div class="nav d-flex justify-content-between align-items-center p-3 bg-dark">
        <h1 class="text-white">MINIBANK</h1>
        <img src="{{ Vite::asset('resources/image/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px; height: auto;">
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Section Historique -->
            <div class="col-md-4 mb-3">
                <div class="historique p-3 bg-light border">
                    <h2 class="text-center">HISTORIQUES</h2>
                    <ul class="list-unstyled">
                        @if(isset($transactions) && $transactions->isNotEmpty())
                            @foreach($transactions as $transaction)
                                <li>
                                    <strong>{{ ucfirst($transaction->type) }}:</strong>
                                    {{ number_format($transaction->montant, 2) }} €
                                    <br>
                                    <small>{{ $transaction->created_at->format('d-m-Y H:i') }}</small>
                                </li>
                            @endforeach
                        @else
                            <li>Aucune transaction enregistrée.</li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Section Opérations -->
            <div class="col-md-8 mb-3">
                <div class="operation text-center bg-light border p-3">
                    <!-- Section Solde -->
                    <div class="solde mt-3 d-flex justify-content-center align-items-center">
                        <i class="fas fa-eye toggle-button" id="toggle" style="cursor: pointer;"></i>
                        <span class="montant ml-3" id="montant">{{ number_format($user->compte->solde ?? 0, 2) }} €</span>
                    </div>
                    <a class="retrait btn btn-primary m-2" href="#">RETRAIT</a>
                    <a class="depot btn btn-success m-2" href="#">DEPOT</a>



                    <!-- Formulaire pour les opérations -->
                    <form id="transactionForm" action="{{ route('transaction.effectuer') }}" method="POST" class="mt-4">
                        @csrf

                        <!-- Champs cachés pour les comptes et le distributeur -->
                        <input type="hidden" name="id_compte_source" value="{{ $user->compte->id ?? '' }}">
                        <input type="hidden" name="id_compte_destinataire" value="{{ old('id_compte_destinataire') }}">
                        <input type="hidden" name="id_distributeur" value="{{ $distributeur->id ?? '' }}">

                        <div class="form-group">
                            <label for="montant">Montant:</label>
                            <input type="number" class="form-control" id="montant" name="montant" min="0.01" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Type de transaction:</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="depot">Dépôt</option>
                                <option value="retrait">Retrait</option>
                                <option value="envoi">Envoi</option>
                            </select>
                        </div>

                        <div class="form-group" id="client_id_group" style="display: none;">
                            <label for="client_id">ID du Client (pour Envoi):</label>
                            <input type="number" class="form-control" id="client_id" name="client_id" placeholder="Entrez l'ID du client" min="1">
                        </div>

                        <button type="submit" class="btn btn-primary m-2">Effectuer la Transaction</button>
                    </form>

                    <script>
                        // Afficher/cacher le champ "ID du Client" selon le type de transaction sélectionné
                        document.getElementById('type').addEventListener('change', function () {
                            var clientIdGroup = document.getElementById('client_id_group');
                            var compteDestinataireInput = document.querySelector('input[name="id_compte_destinataire"]');

                            if (this.value === 'envoi') {
                                clientIdGroup.style.display = 'block';
                                compteDestinataireInput.value = ''; // Réinitialiser le champ caché ID du compte destinataire
                            } else {
                                clientIdGroup.style.display = 'none';
                                compteDestinataireInput.value = null; // Ne pas envoyer de destinataire dans les autres cas
                            }
                        });

                        // Afficher/cacher le montant
                        document.getElementById('toggle').addEventListener('click', function () {
                            var montantElem = document.getElementById('montant');
                            montantElem.style.visibility = montantElem.style.visibility === 'hidden' ? 'visible' : 'hidden';
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    @vite(['/resources/js/client.js'])
    @vite(['resources/js/client.js'])
</body>
</html>
