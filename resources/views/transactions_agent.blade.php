<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Transactions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    @vite(['resources/css/transactions_agent.css'])
</head>
<body>
   <div class="nav"></div>

                <div class="container-fluid">
                    <div class="row">
                        <!-- Barre latérale -->
                        <div class="col-md-2 sidebar">
                        <h4 class="text-white p-3">DASHBOARD</h4>
                <ul class="nav flex-row">
                    
                <li class="nav-item">
                        <a class="nav-link text-white" href="#">DASHBOARD</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">HISTORIQUE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">GESTION CLIENTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">GESTION DISTRIBUTEURS</a>
                    </li>
                </ul>
            </div>



                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-10 p-5">
                                    <h1 class="text-center mb-4">HISTORIQUES DES TRANSACTIONS</h1>
                                    <
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Envoyeur</th>
                                                    <th>Nom Complet</th>
                                                    <th>Montant</th>
                                                    <th>Date de Transaction</th>
                                                    <th>Transaction</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($transactions as $transaction)
                            <tr>
                                <td> <img src="{{ $transaction->photo_source }}" alt="Photo du clients">. {{ $transaction->prenom_source ?? 'Inconnu' }}</td>
                                <td>{{ ($transaction->prenom_source ?? 'Inconnu') . ' ' . ($transaction->nom_source ?? 'Inconnu') }}</td>
                                <td>{{ $transaction->montant }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>
                                    
                                    <button class="btn btn-danger btn-sm">Annuler</button>
                                </td>
                            </tr>
                        @endforeach

                        @if($transactions->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Aucune transaction trouvée.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </>
        </div>
    </div>
</div>

        </div>
    </div>

    <!-- Bootstrap JS et ses dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
