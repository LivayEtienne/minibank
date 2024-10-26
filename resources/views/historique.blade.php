<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Transactions</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Historique des Transactions</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nom du Client (Source)</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Numéro de Compte (Source)</th>
                    <th scope="col">Type</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->clientSource->user ? $transaction->clientSource->user->prenom . ' ' . $transaction->clientSource->user->nom : 'N/A' }}</td>
                        <td>{{ $transaction->clientSource->user ? $transaction->clientSource->user->telephone : 'N/A' }}</td>
                        <td>{{ $transaction->clientSource->numero_compte }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td> <!-- Affichage du type de transaction -->
                        <td>{{ number_format($transaction->montant, 2, ',', ' ') }} F</td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                        <form action="{{ route('transactions.cancel', ['id' => $transaction->id, 'distributeurId' => $distributeur->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Annuler</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
