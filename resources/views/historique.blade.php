<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Transactions</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Styles de la sidebar */
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
            font-family: 'Georgia', serif; /* Appliquer la police Georgia */
        }

        table {
            font-family: 'Georgia', serif; /* Appliquer la police Georgia aux tables aussi */
        }
        .table th, .table td {
        font-size: 1.25rem; /* Ajustez la taille ici */
    }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('distributeur') }}">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('distributeur.history') }}">
                    <i class="fas fa-users"></i> Historiques
                </a>
            </li>          
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Historique des Transactions</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Nom du Client</th>
            <th scope="col">Téléphone</th>
            <th scope="col">Numéro de Compte</th>
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
                <td>{{ ucfirst($transaction->type) }}</td>
                <td>{{ number_format($transaction->montant, 2, ',', ' ') }} F</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
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
