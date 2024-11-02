<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Transactions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Liste des Transactions</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Compte Source</th>
                    <th>Compte Destinataire</th>
                    <th>Distributeur</th>
                    <th>Montant</th>
                    <th>Type</th>
                    <th>Frais</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->id_compte_source }}</td>
                        <td>{{ $transaction->id_compte_destinataire }}</td>
                        <td>{{ $transaction->distributeur ? $transaction->distributeur->numero_compte : 'N/A' }}</td>
                        <td>{{ $transaction->montant }}</td>
                        <td>{{ $transaction->type }}</td>
                        <td>{{ $transaction->frais }}</td>
                        <td>{{ $transaction->statut }}</td>
                        <td>
                            @if($transaction->statut === 'active')
                                <form action="{{ route('transactions.annuler', $transaction->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Annuler</button>
                                </form>
                            @else
                                Annulée
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
